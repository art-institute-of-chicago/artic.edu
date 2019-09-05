<p>Use Markdown to create the table below. See <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet#tables">tutorial</a>.</p>

<hr>

@formField('input', [
    'name' => 'table_title',
    'label' => 'Title',
    'maxlength' => 60,
    'note' => 'Optional',
])

@formField('input', [
    'type' => 'textarea',
    'name' => 'table_markdown',
    'label' => 'Table (Markdown)',
    'rows' => 4,
    'note' => 'Limited to one table per block',
])

@formField('checkbox', [
    'name' => 'has_side_header',
    'label' => 'Leftmost column is also a header',
])
