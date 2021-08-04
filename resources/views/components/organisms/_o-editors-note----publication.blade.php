<div class="o-editors-note">
    @component('components.atoms._link')
        @slot('font', '')
        @slot('href', $articleLink)

        <div class="o-editors-note__inner">
            <div class="o-editors-note__title-lockup f-deck">
                {!! $description !!}<svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
            </div>
        </div>
    @endcomponent
</div>
