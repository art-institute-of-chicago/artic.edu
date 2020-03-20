<div class="o-editors-note">
    @component('components.blocks._text')
        @slot('font', 'f-tag')
        Editor’s Note
    @endcomponent

    <div class="o-editors-note__inner f-deck">
        <div class="o-editors-note__issue-number">
            <span class="deck--black">Issue {{ $issueNumber }}</span>
        </div>
        <div class="o-editors-note__title-lockup">
            <span class="deck--black">{{ $title }}:</span> {!! $description !!}&nbsp;<svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
        </div>
    </div>
</div>
