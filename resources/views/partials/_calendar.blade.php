<div class="m-calendar" id="calendar" data-behavior="calendar">
    <div class="m-calendar__header">
        <button class="btn btn--sm btn--secondary f-buttons s-active" data-calendar-start>From</button>
        <button class="btn btn--sm btn--secondary f-buttons" data-calendar-end>To</button>
        <button class="m-calendar__close" data-calendar-close><svg class="icon--close" aria-title="Close date select"><use xlink:href="#icon--close" /></svg></button>
    </div>
    <div class="m-calendar__months" data-calendar-months>
        <div class="m-calendar__month" style="display: none;" data-calendar-month-template>
            <b class="m-calendar__title f-caption" data-calendar-title></b>
            <table data-calendar-table>
                <thead class="f-caption">
                  <tr>
                    <th title="Sunday">S</th>
                    <th title="Monday">M</th>
                    <th title="Tuesday">T</th>
                    <th title="Wednesday">W</th>
                    <th title="Thursday">T</th>
                    <th title="Friday">F</th>
                    <th title="Saturday">S</th>
                  </tr>
                </thead>
                <tbody class="f-secondary">
                </tbody>
            </table>
        </div>
        <button class="m-calendar__next" data-calendar-next><svg aria-title="Next month" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></button>
        <button class="m-calendar__prev" data-calendar-prev><svg aria-title="Previous month" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></button>
    </div>
    <div class="m-calendar__footer">
        <button class="btn btn--sm f-buttons" data-calendar-done>Done</button>
        <button class="btn btn--sm btn--secondary f-buttons" data-calendar-reset>Reset</button>
    </div>
</div>
