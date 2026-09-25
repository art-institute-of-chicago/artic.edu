<script>
    (function () {
        'use strict';

        var state = {
            source: { module: null, record: null, blocks: [] },
            target: { module: null, record: null, blocks: [] }
        };

        var tokens = { source: 0, target: 0 };
        var dragState = null;
        var targetChosen = false;
        var recordLoaders = {};

        var base = window.location.pathname.replace(/\/+$/, '');
        var dataUrl = base + '/data';
        var pasteUrl = base + '/paste';
        var reorderUrl = base + '/reorder';

        // Live DOM accessors. Never cache nodes: Twill's main-free.js mounts Vue on
        // #app, which compiles the existing DOM as its template and replaces every node.
        // Anything captured before that mount becomes detached, so every handler must
        // re-query the live DOM at call time.
        function bcRoot() {
            return document.querySelector('[data-block-copy]');
        }

        function bcCol(column) {
            return {
                select: document.querySelector('[data-bc-picker="' + column + '"] [data-bc-module]'),
                record: document.querySelector('[data-bc-picker="' + column + '"] [data-bc-record]'),
                options: document.querySelector('[data-bc-picker="' + column + '"] [data-bc-options]'),
                list: document.querySelector('[data-bc-list="' + column + '"]'),
                count: document.querySelector('[data-bc-count="' + column + '"]')
            };
        }

        function bcTargetZone() {
            return document.querySelector('[data-bc-dropzone="target"]')
                || document.querySelector('[data-bc-list="target"]');
        }

        function bcCsrf() {
            var root = bcRoot();

            return root ? (root.getAttribute('data-bc-csrf') || '') : '';
        }

        function readInitial(column, payload) {
            if (!payload || !payload[column]) {
                return;
            }

            var data = payload[column];
            state[column].module = data.module || null;
            state[column].record = data.record === undefined ? null : data.record;
            state[column].blocks = Array.isArray(data.blocks) ? data.blocks : [];
        }

        function seedState() {
            var root = bcRoot();
            var raw = root ? root.getAttribute('data-bc-state') : null;

            if (!raw) {
                return;
            }

            try {
                var initial = JSON.parse(raw);
                readInitial('source', initial);
                readInitial('target', initial);
            } catch (error) {
                // Ignore malformed seed data; the pickers still drive everything else.
            }
        }

        // Re-seed the app state if Vue's mount (or any other DOM swap) left us empty.
        function ensureSeeded() {
            if (state.source.module === null && state.target.module === null) {
                seedState();
            }
        }

        seedState();
        targetChosen = !!(state.target.module && state.target.record !== null);

        function escapeHtml(value) {
            return String(value === null || value === undefined ? '' : value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function editorKey(block) {
            var editor = block.editor === null || block.editor === undefined ? '' : String(block.editor);

            return editor === 'default' ? '' : editor;
        }

        function handleMarkup(label) {
            return '<span class="bc__handle" tabindex="0" role="button" aria-label="' + escapeHtml(label) + '">'
                + '<svg width="8" height="17" aria-hidden="true"><use xlink:href="#icon--drag"></use></svg>'
                + '</span>';
        }

        function rowMarkup(column, block) {
            var meta = [];

            if (block.children > 0) {
                meta.push(block.children + ' children');
            }

            if (block.media > 0) {
                meta.push(block.media + ' images');
            }

            var action = '';
            var attrs = '';
            var handle = '';

            if (column === 'target') {
                attrs = ' draggable="true" data-bc-reorder data-block-id="' + escapeHtml(block.id)
                    + '" data-bc-editor="' + escapeHtml(editorKey(block)) + '"';
                handle = handleMarkup('Reorder block');

                if (block.is_new) {
                    action = '<span class="bc__chip">Just pasted</span>';
                }
            } else if (block.allowed === false) {
                action = '<span class="bc__hint">Not allowed on target</span>';
            } else if (!targetChosen) {
                action = '<span class="bc__hint">Pick a target first</span>';
            } else {
                attrs = ' draggable="true" data-bc-drag="' + escapeHtml(block.id) + '"';
                handle = handleMarkup('Copy block to target');
            }

            return '<li class="bc__row' + (block.is_new ? ' bc__row--new' : '') + '"' + attrs + '>'
                + handle
                + '<span class="bc__pos">' + escapeHtml(block.position) + '</span>'
                + '<span class="bc__badge">' + escapeHtml(block.type) + '</span>'
                + '<span class="bc__preview">' + escapeHtml(block.preview) + '</span>'
                + '<span class="bc__id">#' + escapeHtml(block.id) + '</span>'
                + '<span class="bc__meta">' + escapeHtml(meta.join(' · ')) + '</span>'
                + '<span class="bc__action">' + action + '</span>'
                + '</li>';
        }

        function renderList(column, blocks) {
            var list = bcCol(column).list;

            if (!list) {
                return;
            }

            if (!blocks || blocks.length === 0) {
                list.innerHTML = '<li class="bc__empty">No blocks on this record yet.</li>';

                return;
            }

            var groups = [];
            var seen = {};

            blocks.forEach(function (block) {
                var key = editorKey(block);

                if (!Object.prototype.hasOwnProperty.call(seen, key)) {
                    seen[key] = groups.length;
                    groups.push({ key: key, blocks: [] });
                }

                groups[seen[key]].blocks.push(block);
            });

            list.innerHTML = groups.map(function (group) {
                var rows = group.blocks.map(function (block) {
                    return rowMarkup(column, block);
                }).join('');

                if (groups.length > 1) {
                    rows = '<li class="bc__groupLabel">'
                        + escapeHtml(group.key === '' ? 'default' : group.key)
                        + '</li>' + rows;
                }

                return rows;
            }).join('');
        }

        function renderCount(column, blocks) {
            var badge = bcCol(column).count;

            if (!badge) {
                return;
            }

            badge.textContent = (blocks ? blocks.length : 0) + ' blocks';
        }

        function renderOptions(column, options) {
            var list = bcCol(column).options;

            if (!list || !options) {
                return;
            }

            list.innerHTML = options.map(function (option) {
                return '<option value="' + escapeHtml(option.id) + '">' + escapeHtml(option.label) + '</option>';
            }).join('');
        }

        function showAlert(message, kind, action) {
            var root = bcRoot();
            var alert = root ? root.querySelector('[data-bc-alert]') : null;

            if (!alert) {
                return;
            }

            alert.innerHTML = '';

            if (!message) {
                alert.hidden = true;
                alert.textContent = '';
                alert.className = 'bc__alert';

                return;
            }

            alert.className = 'bc__alert ' + (kind === 'ok' ? 'bc__alert--ok' : 'bc__alert--error');
            alert.appendChild(document.createTextNode(message));

            if (action) {
                var button = document.createElement('button');

                button.type = 'button';
                button.className = 'bc__undo';
                button.textContent = action.label;
                button.addEventListener('click', function () {
                    button.disabled = true;
                    action.onClick();
                });

                alert.appendChild(button);
            }

            alert.hidden = false;
        }

        function fieldValue(column, field) {
            var element = bcCol(column)[field];

            return element ? element.value.trim() : '';
        }

        function fetchData() {
            var url = new URL(dataUrl, window.location.origin);

            var params = {
                source_module: fieldValue('source', 'select'),
                source_record: fieldValue('source', 'record'),
                target_module: fieldValue('target', 'select'),
                target_record: fieldValue('target', 'record')
            };

            Object.keys(params).forEach(function (key) {
                if (params[key] !== null && params[key] !== undefined && params[key] !== '') {
                    url.searchParams.set(key, params[key]);
                }
            });

            return fetch(url.toString(), {
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin'
            }).then(function (response) {
                return response.json();
            });
        }

        function applyColumn(column, payload) {
            var data = payload[column] || {};

            state[column].module = data.module || null;
            state[column].record = data.record === undefined ? null : data.record;

            if (Array.isArray(data.blocks)) {
                state[column].blocks = data.blocks;
            }
        }

        function renderColumn(column, payload) {
            var data = payload[column] || {};

            renderList(column, data.blocks || []);
            renderCount(column, data.blocks || []);
            renderOptions(column, data.options);
        }

        function load(column, requireRecord) {
            if (requireRecord && fieldValue(column, 'record') === '') {
                return;
            }

            var token = ++tokens[column];
            var sourceToken = column === 'target' ? ++tokens.source : null;

            fetchData().then(function (payload) {
                if (token !== tokens[column]) {
                    return;
                }

                applyColumn(column, payload);

                if (sourceToken !== null && sourceToken === tokens.source) {
                    applyColumn('source', payload);
                }

                targetChosen = !!(state.target.module && state.target.record !== null);

                renderColumn(column, payload);

                if (sourceToken !== null && sourceToken === tokens.source) {
                    renderColumn('source', payload);
                }

                var error = payload[column] ? payload[column].error : null;

                showAlert(error || '', error ? 'error' : '');
            }).catch(function () {
                if (token !== tokens[column]) {
                    return;
                }

                showAlert('Could not load block data. Please try again.', 'error');
            });
        }

        function sendPaste(fields) {
            ensureSeeded();

            var body = new FormData();

            Object.keys(fields).forEach(function (key) {
                if (key === '_token') {
                    return;
                }

                var value = fields[key];

                body.append(key, value === null || value === undefined ? '' : value);
            });

            body.append('_token', bcCsrf());

            var root = bcRoot();

            if (root) {
                root.classList.add('bc--busy');
            }

            return fetch(pasteUrl, {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
                body: body,
                credentials: 'same-origin'
            }).then(function (response) {
                return response.json().then(function (payload) {
                    return { ok: response.ok, payload: payload };
                });
            }).then(function (result) {
                if (!result.ok || !result.payload || !result.payload.ok) {
                    var message = result.payload && result.payload.errors && result.payload.errors.paste;

                    showAlert(message || 'Could not paste the block.', 'error');

                    return false;
                }

                var blocks = result.payload.target ? result.payload.target.blocks : [];

                applyColumn('target', result.payload);
                targetChosen = !!(state.target.module && state.target.record !== null);
                renderList('target', blocks);
                renderCount('target', blocks);

                showAlert(result.payload.message || 'Pasted.', 'ok');

                return true;
            }).catch(function () {
                showAlert('Could not paste the block.', 'error');

                return false;
            }).finally(function () {
                var live = bcRoot();

                if (live) {
                    live.classList.remove('bc--busy');
                }
            });
        }

        function snapshotBlocks() {
            return (state.target.blocks || []).map(function (block) {
                return Object.assign({}, block);
            });
        }

        function currentNewIds() {
            var ids = {};
            var list = bcCol('target').list;

            if (!list) {
                return ids;
            }

            list.querySelectorAll('.bc__row--new[data-block-id]').forEach(function (row) {
                ids[String(row.getAttribute('data-block-id'))] = true;
            });

            return ids;
        }

        function groupRows(editor) {
            var list = bcCol('target').list;

            if (!list) {
                return [];
            }

            return Array.prototype.slice.call(list.querySelectorAll('[data-bc-reorder]')).filter(function (row) {
                return (row.getAttribute('data-bc-editor') || '') === editor;
            });
        }

        function groupIds(editor) {
            return groupRows(editor).map(function (row) {
                return Number(row.getAttribute('data-block-id'));
            });
        }

        function restoreBlocks(blocks) {
            if (!blocks) {
                return;
            }

            state.target.blocks = blocks;
            renderList('target', blocks);
            renderCount('target', blocks);
        }

        function saveOrder(ids, editor, previousBlocks, previousOrder, successMessage) {
            ensureSeeded();

            var newIds = currentNewIds();

            var root = bcRoot();

            if (root) {
                root.classList.add('bc--busy');
            }

            return fetch(reorderUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': bcCsrf()
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    module: state.target.module,
                    record: state.target.record,
                    editor: editor === '' ? null : editor,
                    ids: ids
                })
            }).then(function (response) {
                return response.json().then(function (payload) {
                    return { ok: response.ok, payload: payload };
                });
            }).then(function (result) {
                if (!result.ok || !result.payload || !result.payload.ok) {
                    restoreBlocks(previousBlocks);

                    var error = result.payload && result.payload.errors && result.payload.errors.reorder;

                    showAlert(error || 'Could not save the new order.', 'error');

                    return;
                }

                var blocks = (result.payload.blocks || []).map(function (block) {
                    block.is_new = !!newIds[String(block.id)];

                    return block;
                });

                state.target.blocks = blocks;
                renderList('target', blocks);
                renderCount('target', blocks);

                var undo = null;

                if (previousOrder && previousOrder.length) {
                    undo = {
                        label: 'Undo',
                        onClick: function () {
                            saveOrder(previousOrder, editor, blocks, ids, 'Restored the previous order.');
                        }
                    };
                }

                showAlert(successMessage || 'Saved the new order.', 'ok', undo);
            }).catch(function () {
                restoreBlocks(previousBlocks);
                showAlert('Could not save the new order.', 'error');
            }).finally(function () {
                var live = bcRoot();

                if (live) {
                    live.classList.remove('bc--busy');
                }
            });
        }

        function clearDropIndicators() {
            var list = bcCol('target').list;

            if (!list) {
                return;
            }

            list.querySelectorAll('.bc__row--drop-before, .bc__row--drop-after').forEach(function (row) {
                row.classList.remove('bc__row--drop-before');
                row.classList.remove('bc__row--drop-after');
            });
        }

        function removeColumnDrop() {
            var zone = bcTargetZone();

            if (zone) {
                zone.classList.remove('bc__column--drop');
            }
        }

        function endDrag() {
            if (dragState && dragState.row) {
                dragState.row.classList.remove('bc__row--dragging');
                dragState.row.removeAttribute('aria-grabbed');
            }

            clearDropIndicators();
            removeColumnDrop();

            var root = bcRoot();

            if (root) {
                root.classList.remove('bc--copying');
            }

            dragState = null;
        }

        var RECORD_LOOKUP_DELAY = 3000;

        function debounce(fn, wait) {
            var timer = null;

            return function () {
                clearTimeout(timer);
                timer = setTimeout(fn, wait);
            };
        }

        function loadRecordDebounced(column) {
            var field = bcCol(column).record;

            // A bare id is unambiguous: resolve it right away. A typed title waits a few
            // seconds so we do not report "no record found" mid-typing.
            if (field && /^\s*\d+\s*$/.test(field.value)) {
                load(column, true);

                return;
            }

            if (!recordLoaders[column]) {
                recordLoaders[column] = debounce(function () {
                    load(column, true);
                }, RECORD_LOOKUP_DELAY);
            }

            recordLoaders[column]();
        }

        // --- Delegated document listeners -------------------------------------------
        // Every handler survives Vue replacing the DOM because it resolves live nodes
        // via the bc* accessors at event time instead of holding captured references.

        document.addEventListener('submit', function (event) {
            var form = event.target;

            if (!form || !form.matches || !form.closest('[data-block-copy]')) {
                return;
            }

            if (form.matches('[data-bc-picker]')) {
                event.preventDefault();
                load(form.getAttribute('data-bc-picker'), false);
            }
        });

        document.addEventListener('dragstart', function (event) {
            var root = bcRoot();

            if (!root) {
                return;
            }

            if (root.classList.contains('bc--busy')) {
                event.preventDefault();

                return;
            }

            var row = event.target && event.target.closest
                ? event.target.closest('[data-bc-reorder], [data-bc-drag]')
                : null;

            if (!row || !root.contains(row)) {
                return;
            }

            if (row.hasAttribute('data-bc-reorder')) {
                var editor = row.getAttribute('data-bc-editor') || '';

                dragState = {
                    type: 'reorder',
                    row: row,
                    editor: editor,
                    previousOrder: groupIds(editor),
                    previousBlocks: snapshotBlocks()
                };

                row.classList.add('bc__row--dragging');
                row.setAttribute('aria-grabbed', 'true');

                if (event.dataTransfer) {
                    event.dataTransfer.effectAllowed = 'move';
                    event.dataTransfer.setData('text/plain', row.getAttribute('data-block-id') || '');
                }

                return;
            }

            var id = row.getAttribute('data-bc-drag') || '';

            dragState = { type: 'copy', id: id, row: row };

            row.setAttribute('aria-grabbed', 'true');
            root.classList.add('bc--copying');

            if (event.dataTransfer) {
                event.dataTransfer.effectAllowed = 'copy';
                event.dataTransfer.setData('text/plain', id);
            }
        });

        document.addEventListener('dragend', function () {
            endDrag();
        });

        document.addEventListener('keydown', function (event) {
            var root = bcRoot();

            if (!root) {
                return;
            }

            var handle = event.target && event.target.closest ? event.target.closest('.bc__handle') : null;

            if (!handle) {
                return;
            }

            // Keyboard equivalent of dragging a source row onto the target column.
            if (event.key === 'Enter' || event.key === ' ' || event.key === 'Spacebar') {
                var sourceRow = handle.closest('[data-bc-drag]');

                if (sourceRow) {
                    event.preventDefault();

                    if (root.classList.contains('bc--busy')) {
                        return;
                    }

                    var sourceId = sourceRow.getAttribute('data-bc-drag') || '';

                    if (!sourceId || !targetChosen) {
                        return;
                    }

                    var sourceBadge = sourceRow.querySelector('.bc__badge');
                    var sourceType = sourceBadge ? sourceBadge.textContent : 'block';

                    sendPaste({
                        block_id: sourceId,
                        source_module: state.source.module || '',
                        source_record: state.source.record === null ? '' : state.source.record,
                        target_module: state.target.module || '',
                        target_record: state.target.record === null ? '' : state.target.record
                    }).then(function (copied) {
                        if (copied) {
                            showAlert('Copied ' + sourceType + ' to ' + state.target.module + ':' + state.target.record + '.', 'ok');
                        }
                    });

                    return;
                }
            }

            var row = handle.closest('[data-bc-reorder]');
            var list = bcCol('target').list;

            if (!row || !list || !list.contains(row)) {
                return;
            }

            var editor = row.getAttribute('data-bc-editor') || '';
            var rows = groupRows(editor);
            var index = rows.indexOf(row);

            if (index === -1) {
                return;
            }

            var badge = row.querySelector('.bc__badge');
            var type = badge ? badge.textContent : 'block';

            if (event.key === 'Enter' || event.key === ' ' || event.key === 'Spacebar') {
                event.preventDefault();
                showAlert(type + ', position ' + (index + 1) + ' of ' + rows.length + '. Use Alt+Arrow to move.', 'ok');

                return;
            }

            if (!event.altKey || (event.key !== 'ArrowUp' && event.key !== 'ArrowDown')) {
                return;
            }

            event.preventDefault();

            if (root.classList.contains('bc--busy')) {
                return;
            }

            var target = event.key === 'ArrowUp' ? index - 1 : index + 1;

            if (target < 0 || target >= rows.length) {
                return;
            }

            var previousBlocks = snapshotBlocks();
            var previousOrder = groupIds(editor);

            if (event.key === 'ArrowUp') {
                rows[target].parentNode.insertBefore(row, rows[target]);
            } else {
                rows[target].parentNode.insertBefore(row, rows[target].nextSibling);
            }

            saveOrder(
                groupIds(editor),
                editor,
                previousBlocks,
                previousOrder,
                'Moved ' + type + ' from position ' + (index + 1) + ' to ' + (target + 1) + '.'
            );
        });

        document.addEventListener('dragenter', function (event) {
            var zone = bcTargetZone();

            if (!zone || !dragState || dragState.type !== 'copy') {
                return;
            }

            if (!zone.contains(event.target)) {
                return;
            }

            event.preventDefault();
            zone.classList.add('bc__column--drop');
        });

        document.addEventListener('dragover', function (event) {
            var zone = bcTargetZone();

            if (!zone || !dragState || !zone.contains(event.target)) {
                return;
            }

            if (dragState.type === 'copy') {
                event.preventDefault();

                if (event.dataTransfer) {
                    event.dataTransfer.dropEffect = 'copy';
                }

                zone.classList.add('bc__column--drop');

                return;
            }

            if (dragState.type === 'reorder') {
                event.preventDefault();

                var row = event.target && event.target.closest
                    ? event.target.closest('[data-bc-reorder]')
                    : null;

                clearDropIndicators();

                if (!row || row === dragState.row) {
                    return;
                }

                if ((row.getAttribute('data-bc-editor') || '') !== dragState.editor) {
                    return;
                }

                var rect = row.getBoundingClientRect();
                var after = event.clientY > rect.top + (rect.height / 2);

                row.classList.add(after ? 'bc__row--drop-after' : 'bc__row--drop-before');
            }
        });

        document.addEventListener('dragleave', function (event) {
            var zone = bcTargetZone();

            if (!zone || !dragState || dragState.type !== 'copy') {
                return;
            }

            if (!zone.contains(event.target)) {
                return;
            }

            if (event.relatedTarget && zone.contains(event.relatedTarget)) {
                return;
            }

            zone.classList.remove('bc__column--drop');
        });

        document.addEventListener('drop', function (event) {
            var zone = bcTargetZone();

            if (!zone || !dragState || !zone.contains(event.target)) {
                return;
            }

            if (dragState.type === 'copy') {
                event.preventDefault();
                zone.classList.remove('bc__column--drop');

                var dropped = '';

                try {
                    dropped = event.dataTransfer.getData('text/plain');
                } catch (error) {
                    dropped = '';
                }

                var blockId = dropped || dragState.id;

                var copyFields = {
                    block_id: blockId,
                    source_module: state.source.module || '',
                    source_record: state.source.record === null ? '' : state.source.record,
                    target_module: state.target.module || '',
                    target_record: state.target.record === null ? '' : state.target.record
                };

                endDrag();

                if (!blockId) {
                    return;
                }

                sendPaste(copyFields);

                return;
            }

            if (dragState.type === 'reorder') {
                event.preventDefault();
                zone.classList.remove('bc__column--drop');

                var dragged = dragState;
                var targetRow = event.target && event.target.closest
                    ? event.target.closest('[data-bc-reorder]')
                    : null;

                clearDropIndicators();

                if (targetRow && (targetRow.getAttribute('data-bc-editor') || '') !== dragged.editor) {
                    showAlert('Blocks can only be reordered within the same editor.', 'error');
                    endDrag();

                    return;
                }

                if (targetRow && targetRow === dragged.row) {
                    endDrag();

                    return;
                }

                if (targetRow) {
                    var targetRect = targetRow.getBoundingClientRect();

                    if (event.clientY > targetRect.top + (targetRect.height / 2)) {
                        targetRow.parentNode.insertBefore(dragged.row, targetRow.nextSibling);
                    } else {
                        targetRow.parentNode.insertBefore(dragged.row, targetRow);
                    }
                } else {
                    var siblings = groupRows(dragged.editor);
                    var lastRow = siblings[siblings.length - 1];

                    // Dropped on the column but not on a row: append to the end of this editor group.
                    if (!lastRow || lastRow === dragged.row) {
                        endDrag();

                        return;
                    }

                    lastRow.parentNode.insertBefore(dragged.row, lastRow.nextSibling);
                }

                var ids = groupIds(dragged.editor);
                var previousOrder = dragged.previousOrder;
                var previousBlocks = dragged.previousBlocks;

                endDrag();
                saveOrder(ids, dragged.editor, previousBlocks, previousOrder, 'Saved the new order.');
            }
        });

        document.addEventListener('change', function (event) {
            var target = event.target;

            if (!target || !target.closest) {
                return;
            }

            var picker = target.closest('[data-bc-picker]');

            if (!picker || !picker.closest('[data-block-copy]')) {
                return;
            }

            var column = picker.getAttribute('data-bc-picker');

            if (!column) {
                return;
            }

            if (target.matches('[data-bc-module]')) {
                load(column, false);

                return;
            }

            if (target.matches('[data-bc-record]')) {
                loadRecordDebounced(column);
            }
        });

        document.addEventListener('input', function (event) {
            var target = event.target;

            if (!target || !target.closest || !target.matches('[data-bc-record]')) {
                return;
            }

            var picker = target.closest('[data-bc-picker]');

            if (!picker || !picker.closest('[data-block-copy]')) {
                return;
            }

            var column = picker.getAttribute('data-bc-picker');

            if (!column) {
                return;
            }

            loadRecordDebounced(column);
        });
    })();
</script>
