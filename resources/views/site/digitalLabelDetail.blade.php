@extends('layouts.app')
@section('content')
    <section class="o-closer-look" data-behavior="closerLook">
        <script type="application/json" data-closerLook-contentBundle>
            {{-- {{ dd($item->contentBundle) }} --}}
            {!! json_encode($item->contentBundle) !!}
        </script>
        <script type="application/json" data-closerLook-assetLibrary>
            [{"type":"sequence","title":"Magic Circle","id":"45844182", "width": 683, "height": 1024, "src":[{"src":"0a2fe150-b1fa-4781-876b-cc04abcebd8b","frame":0},{"src":"99f8f048-d690-4a64-918e-4602c0441950","frame":1},{"src":"4f792c29-d0dc-4687-967c-d2227f7fa571","frame":2},{"src":"cc8db0ff-cef5-44fb-ac68-634a245d5f65","frame":3},{"src":"89baa843-8548-46f9-8ef0-bb17a809e7ab","frame":4},{"src":"0bbc2f83-4018-4b1c-a0af-bc04e7445cf3","frame":5},{"src":"23d68106-81a8-4312-928e-50e4cb05b533","frame":6},{"src":"0df59568-ff9a-48f2-b1b4-29cd5e2abb6f","frame":7}]},{"type":"sequence","title":"Author CallOut","id":"31110133", "width": 3000, "height": 4168, "src":[{"src":"31c062d2-0058-4978-a4a4-32b3017dc0ea","frame":0},{"src":"a7bcba07-3426-4fdd-af86-db6c5e19304d","frame":1},{"src":"e23c6f4d-a8e2-4940-bdcc-18e133c86418","frame":2},{"src":"5fa63c69-2fe5-40ea-bbad-32f479f4aed7","frame":3},{"src":"57e74e28-23a4-4ce7-82de-eba2d00591d9","frame":4},{"src":"de8bee9b-86b2-4ffe-9e1e-8aa52bc76fb3","frame":5},{"src":"ecf563aa-9ae6-4b91-8809-b8a7c05bedb1","frame":6},{"src":"c96f4eba-1296-47ce-a2f0-74888618d318","frame":7},{"src":"d1d14d28-a855-4737-9d0a-5440c3e0ec02","frame":8},{"src":"ac49a66b-21e1-45fe-9503-a8473c2e9d5e","frame":9},{"src":"7fd638ec-2408-45a0-8d5c-387835a56d9c","frame":10},{"src":"474ce8b1-e10a-47ae-aca8-31e53472a07f","frame":11},{"src":"0c303dbc-1256-4d70-bcf7-dfe0d56e2c23","frame":12},{"src":"e62b7691-e0fd-44c9-9936-4de176cac673","frame":13},{"src":"aa9a56e3-7799-4463-a375-155df7536589","frame":14},{"src":"c3d37ca6-195a-4578-a289-26febe4d6bc3","frame":15},{"src":"0b5ad9f2-2a7b-48c2-b825-96e168078a74","frame":16},{"src":"7fa8142c-afb9-42c7-9af2-fb476b347187","frame":17},{"src":"a952343e-704d-42d3-92fa-ae1b7e2d7d19","frame":18},{"src":"66d192a0-3bc0-4397-a674-a72116af1f07","frame":19},{"src":"de2a9a96-0b2d-492e-9163-6cb1d91c5dad","frame":20},{"src":"50e28003-fd7f-4234-9bdd-a0700e3c800f","frame":21},{"src":"2c290028-3a71-451b-a100-ca84c010bddd","frame":22},{"src":"7deb0837-4265-4ca8-ae1f-82dd1fd51e55","frame":23}]},{"type":"sequence","title":"Art Of Defense Animation","id":"81030626","src":[]},{"type":"image","title":"Author _end","id":"72484837","width": 683, "height": 1024, "src":["3cf66812-d0f8-4502-80b7-b21d47fd89a7"]},{"type":"sequence","title":"Gauntlet","id":"24108049", "width": 2700, "height": 1519, "src":[{"src":"181fb35e-0956-4ffd-8d49-2eedb32c41e5","frame":0},{"src":"4ba7956c-67d1-4970-ab04-358a49574ed4","frame":1},{"src":"7c4e617a-c48a-4321-ae0a-2533f0ba1360","frame":2},{"src":"62d8158c-e0cf-4f9b-bbf7-433abc9cdc13","frame":3},{"src":"74d74010-f66c-45fe-a762-d8999726fd14","frame":4},{"src":"3cff6476-a03a-48c1-b47a-8ce97d82d705","frame":5},{"src":"4034aaf1-f5a2-4ceb-aa84-df5f69bf22a5","frame":6},{"src":"bf05b294-47b5-4005-80f1-e7822c9536fc","frame":7},{"src":"d7b5fda8-bbc1-42c3-9682-07722ae5e283","frame":8},{"src":"ef35c07b-9f21-4a4e-ace5-66460445aa89","frame":9},{"src":"966e0cfd-566a-40db-826b-c13a334e4116","frame":10},{"src":"c0b1d549-ef7e-432c-8f3b-c37f24e8ed5e","frame":11},{"src":"b2326e01-a6db-4f9c-bd18-b5565e9b54d5","frame":12},{"src":"6e8c5173-af40-40a7-822a-4737013e1ce0","frame":13},{"src":"babcf529-82b9-4027-bd48-7a15ae690205","frame":14},{"src":"fe7f5155-ca47-451b-9f0b-fa1bb4af757d","frame":15},{"src":"93857c75-9731-4d8b-97b8-e8aad5f5db84","frame":16},{"src":"76a3f7cb-9b4a-49ab-9e79-f4b9927165fd","frame":17},{"src":"42735473-c2e8-41d8-b5d8-126e9ff4745e","frame":18},{"src":"aa936e93-101e-4996-9956-15f8382f2fbd","frame":19},{"src":"a568f5c8-55f9-4691-a0b4-61d08c754410","frame":20},{"src":"57e1c28b-7158-414c-a1e6-3b5ab5662fc6","frame":21},{"src":"9699f1b3-c124-4514-98cd-96d8c7265a61","frame":22},{"src":"1d16ef84-6ae1-4a50-b9bd-df4773958237","frame":23},{"src":"07a2a2d1-c375-4e25-a477-0af6a9433625","frame":24},{"src":"dfacd0cc-2972-4618-8391-c6948f685bb2","frame":25},{"src":"98c90726-66b5-4592-bf92-4148d7058ded","frame":26},{"src":"f0ab8ee2-14ad-491a-8c19-6dbd1ce409cd","frame":27},{"src":"2bada28d-a1b3-468f-a66e-5c4a269c5bc6","frame":28},{"src":"7ae614a3-cce5-49a3-9688-ffa9981ebe3c","frame":29},{"src":"4316df81-1409-4ad2-b719-838f597907af","frame":30},{"src":"13f06b24-1442-48a9-b55b-a6a6a92c83dd","frame":31},{"src":"4978a3c4-d446-40e7-b0af-d011a054e0d2","frame":32},{"src":"1d0c73fa-a35e-4973-8af1-fef3e17871c8","frame":33},{"src":"c405af0a-1583-4423-b1df-524342a06e6b","frame":34},{"src":"d1c85d93-b95e-4915-9688-21b1bb0c075b","frame":35},{"src":"393660e0-dc8d-49ed-baa0-06e5bc8f9419","frame":36},{"src":"3ee22caa-c7c6-4e3b-8004-540d25c6281e","frame":37},{"src":"3813182c-d273-4c01-9a95-7be2ce454062","frame":38},{"src":"03212bd4-49b7-4a85-b771-0a9900eff7ae","frame":39},{"src":"344547a5-3aeb-44c0-98a7-eb4f878f948f","frame":40},{"src":"c8713501-4be8-490d-a000-44149ad54e7c","frame":41},{"src":"52afa456-78b9-4bc8-ae1b-8b9aba04f6bc","frame":42},{"src":"8e199a45-e8f9-443a-b8a5-6d30bcd7ffc3","frame":43},{"src":"f6576265-4c51-477c-8256-4a04f95b7632","frame":44},{"src":"e5c9ddfd-e7f1-4bbf-8e9e-8d0222f47c37","frame":45},{"src":"58236b96-b64c-4054-9a4b-38dd7eee2f52","frame":46},{"src":"3006965d-62b5-4563-88e8-801b36c4fd2b","frame":47},{"src":"ad104326-cb1d-498b-9a29-cd6bc4eb7b42","frame":48},{"src":"bc90966d-04bb-48cc-81e8-5ae43c11f8d7","frame":49},{"src":"ba2f456a-acb3-4cee-83e2-3eaee5c911ea","frame":50},{"src":"ff16d96a-d8e2-4f28-8547-7a46d7198da6","frame":51},{"src":"1931c4aa-64ff-4436-b079-2953abb9680b","frame":52},{"src":"b65193cd-5131-4008-affc-5a402f362a07","frame":53},{"src":"2dfbb8e2-d4ff-4b7e-8c0d-b1eb7a7b26e9","frame":54},{"src":"ecd867d1-cb72-4293-82e4-bc06aaca866c","frame":55},{"src":"c0eab326-a625-41d0-a91a-c38596be8d05","frame":56},{"src":"550fdb92-78ef-448b-ac69-000dc0fc2fce","frame":57},{"src":"742283c3-7711-4504-a838-360e6be875af","frame":58},{"src":"41768d7d-e555-4838-bfc5-95ad60a788c1","frame":59},{"src":"e2c33f4d-531c-4d7d-ad52-3fef2c87c382","frame":60},{"src":"f97d48ae-a213-4ca8-b161-d9f7dec314bb","frame":61},{"src":"c698c26f-629e-4faa-a221-08b54d3b1d2e","frame":62},{"src":"ccd5fa98-aa7d-4b66-9d70-453120ae92b7","frame":63},{"src":"4198b8d0-4c30-44f1-b345-257d9701a23a","frame":64},{"src":"6e1ea1db-f90b-4f91-bbec-95b8414374a7","frame":65},{"src":"a322e400-9c8b-4a7b-9227-9c62a98430f2","frame":66},{"src":"18b70a22-acc8-44db-8b59-363b3aee958a","frame":67},{"src":"07a6d214-aaa6-48f8-8f02-9c5cc18bb6c7","frame":68},{"src":"bafd3f92-f56c-4850-b58c-f42ee09174ca","frame":69},{"src":"6c73e73e-8735-4d38-860e-ddd172d5da70","frame":70},{"src":"4f5de957-7b0d-46fe-a281-ba89aa362823","frame":71}]}]
        </script>
    </section>
    {{-- <section class="o-closer-look" data-behavior="closerLook">
        <script type="application/json" data-closerLook-contentBundle>
            [{"id":34130849,"type":"attract","headline":"Lessons for Mind and Body","subhead":"The Academy of the sword","media":[{"src":"3c89a0de-b8e2-438b-8564-6f8afaea002b","credits":{"creditsACP":"Girard Thibault (Flemish, died ca. 1629)","creditsTitle":"Academie de l'espee","creditsDate":"1627","creditsMedium":"Illustrated book","creditsDimensions":"","creditsCreditLine":"","creditsRefNum":"","creditsCopyright":"","type":"manual"},"altText":""},{"src":"70247348-01b7-45e9-b3b3-19f26d87ef25","credits":{"creditsACP":"Gérard Thibault","creditsTitle":"Academie de l'espée","creditsDate":"1627","creditsMedium":"Illustrated book","creditsDimensions":"","creditsCreditLine":"","creditsRefNum":"","creditsCopyright":"","type":"manual"},"altText":""},{"src":"cf814864-e9cf-4cb7-bf6e-0c5d9187e150","credits":{"creditsACP":"Gérard Thibault","creditsTitle":"Academie de l'espée","creditsDate":"1627","creditsMedium":"Illustrated book","creditsDimensions":"","creditsCreditLine":"","creditsRefNum":"","creditsCopyright":"","type":"manual"},"altText":""},{"src":"dbd760c7-ddb1-48d8-b699-abc6842512c9","credits":{"creditsACP":"Gérard Thibault","creditsTitle":"Academie de l'espée","creditsDate":"1627","creditsMedium":"Illustrated book","creditsDimensions":"","creditsCreditLine":"","creditsRefNum":"","creditsCopyright":"","type":"manual"},"altText":""}],"__option_subhead":true,"seamlessAsset":{"assetID":"0","x":0,"y":0,"scale":1,"frame":0},"assetType":"standard","__mediaType":null,"moduleTitle":"","exhibitionId":"114","isActive":true,"experienceID":"563","experienceType":"LABEL","colorCode":"#3D4DCC","bgColorCode":"#f7f7f7","vScalePercent":0.87109375},{"id":55010050,"type":"split","__mediaType__options":["image","video"],"__option_inset":false,"__option_primary_modal":false,"__option_headline":false,"__option_flip":false,"__option_secondary_image":false,"__option_caption":false,"media":[],"headline":"Lorem Ipsum","primaryCopy":"Academie de L’espee (Academy of the Sword) published in 1630, is one of the most richly illustrated books of its time.&nbsp;<br><br>This virtual academy schooled upperclass students in the art of self-defense. Swordsmanship was perceived as an exercise of the mind and the body.","imglink":{"type":"imagelink","src":"","modalReference":"","caption":"Vivamus interdum suscipit leo, non suscipit purus dignissim quis."},"primaryimglink":{"modalReference":""},"modals":[],"seamlessAsset":{"assetID":"31110133","frame":23,"x":1.9666668258952662,"y":1.4395394393516767,"scale":0.22039999999999998},"assetType":"seamless","__option_secondary_modal":false,"__mediaType":null,"moduleTitle":"Intro","exhibitionId":"114","isActive":true,"experienceID":"563","experienceType":"LABEL","colorCode":"#3D4DCC","bgColorCode":"#f7f7f7","vScalePercent":0.9658203125},{"id":12705574,"type":"split","__mediaType__options":["image","video"],"__option_inset":false,"__option_primary_modal":false,"__option_headline":false,"__option_flip":false,"__option_secondary_image":false,"__option_caption":false,"media":[],"headline":"Lorem Ipsum","primaryCopy":"The book’s author, Gerard Thibault d’Anvers, was the son of a prosperous wool merchant in Antwerp. Thibault’s own privileged education included studying the sword alongside architecture, medicine, and poetry. He eventually became a master swordsman, teaching skills to the wealthy elite.","imglink":{"type":"imagelink","src":"","modalReference":"","caption":"Vivamus interdum suscipit leo, non suscipit purus dignissim quis."},"primaryimglink":{"modalReference":""},"modals":[],"seamlessAsset":{"assetID":"31110133","frame":0,"x":-25.4666660552517,"y":-46.88099765320643,"scale":0.8014},"assetType":"seamless","__option_secondary_modal":false,"__mediaType":null,"moduleTitle":"Author","exhibitionId":"114","isActive":true,"experienceID":"563","experienceType":"LABEL","colorCode":"#3D4DCC","bgColorCode":"#f7f7f7","vScalePercent":0.9658203125},{"id":55829165,"type":"fullwidthmedia","__mediaType__options":["video","image"],"__mediaType":"video","__option_open_modal":false,"__option_autoplay":true,"__option_inset":false,"__option_zoomable":false,"__option_caption":false,"__option_loop":false,"caption":"This is an example caption","src":["984f6bc2-9435-47ea-9ea2-5888ab33e517"],"modals":[],"modalReference":"","seamlessAsset":{"assetID":"45844182","frame":0,"x":0,"y":0,"scale":1},"poster":"004b991e-f005-46ea-95eb-8f87af21d61d","assetType":"standard","__option_controls":true,"__option_reverse":false,"__option_infinite":true,"media":[],"moduleTitle":"Magic Circle Animation","exhibitionId":"114","isActive":true,"experienceID":"563","experienceType":"LABEL","colorCode":"#3D4DCC","bgColorCode":"#f7f7f7","vScalePercent":0.4453125},{"id":14471233,"type":"split","__mediaType__options":["image","video"],"__option_inset":false,"__option_primary_modal":false,"__option_headline":false,"__option_flip":false,"__option_secondary_image":true,"__option_caption":false,"media":[],"headline":"Lorem Ipsum","primaryCopy":"This diagram shows a “mystical circle,” in which man is at the center of all things. In Thibault’s manual, the circle was a unit for measuring space, movement, footing, and the point of the swordsman's blade.&nbsp;","imglink":{"type":"imagelink","src":{"src":"7c5201d4-19bd-42a2-a553-fac45ee2f152","credits":{},"altText":""},"modalReference":"92285319","caption":"Vivamus interdum suscipit leo, non suscipit purus dignissim quis."},"primaryimglink":{"modalReference":""},"modals":[{"__option_autoplay":true,"__option_controls":true,"__option_inset":false,"__option_caption":false,"__option_loop":false,"id":"92285319","__mediaType":"video","src":["c228ca69-6103-43ef-9d4d-071efe4bc6a4"],"caption":"This is an example caption","poster":"e3b8bc1b-4697-41c0-9a5d-23d7fc7c5465"}],"seamlessAsset":{"assetID":"45844182","frame":6,"x":-0.14641288433382194,"y":0.09765625,"scale":1},"assetType":"seamless","__option_secondary_modal":true,"__mediaType":null,"moduleTitle":"Magic Circle 1","exhibitionId":"114","isActive":true,"experienceID":"563","experienceType":"LABEL","colorCode":"#3D4DCC","bgColorCode":"#f7f7f7","vScalePercent":0.568359375},{"id":50156665,"type":"split","__mediaType__options":["image","video"],"__option_inset":false,"__option_primary_modal":false,"__option_headline":false,"__option_flip":false,"__option_secondary_image":true,"__option_caption":false,"media":[],"headline":"Lorem Ipsum","primaryCopy":"Renaissance humanists like Thibault conceived of man's body and mind as the center of the universe. Expand the video below to see how Thibault's ordered the universe.&nbsp;","imglink":{"type":"imagelink","src":{"src":"501e4ad9-e006-476c-bd0a-b51625a4b8f6","credits":{},"altText":""},"modalReference":"70807459","caption":"Vivamus interdum suscipit leo, non suscipit purus dignissim quis."},"primaryimglink":{"modalReference":""},"modals":[{"__option_autoplay":true,"__option_controls":false,"__option_controls_light":true,"__option_inset":false,"__option_caption":false,"__option_loop":false,"id":"70807459","__mediaType":"video","src":["3dd2c111-b805-4575-8a51-57db348d6b77"],"caption":"This is an example caption","poster":"ead4b67d-941c-4281-8c77-e2a3d9ed86ae"}],"seamlessAsset":{"assetID":"45844182","frame":0,"x":-0.14641288433382138,"y":0.09765625,"scale":1},"assetType":"seamless","__option_secondary_modal":true,"__mediaType":null,"moduleTitle":"Magic Circle 2","exhibitionId":"114","isActive":true,"experienceID":"563","experienceType":"LABEL","colorCode":"#3D4DCC","bgColorCode":"#f7f7f7","vScalePercent":0.568359375},{"id":64619168,"type":"fullwidthmedia","__mediaType__options":["video","image"],"__mediaType":"video","__option_open_modal":false,"__option_autoplay":true,"__option_inset":false,"__option_zoomable":false,"__option_caption":false,"__option_loop":false,"caption":"This is an example caption","src":["b707e259-b71e-4304-9a2a-66bdbdf4c9f5"],"modals":[],"modalReference":"","seamlessAsset":{"assetID":null,"frame":1,"x":0,"y":0,"scale":1},"poster":"10131016-4517-436f-9ac1-d9e656058711","assetType":"standard","__option_controls":true,"__option_reverse":false,"__option_infinite":true,"media":[],"moduleTitle":"Hilt Animation","exhibitionId":"114","isActive":true,"experienceID":"563","experienceType":"LABEL","colorCode":"#3D4DCC","bgColorCode":"#f7f7f7","vScalePercent":0.4560546875},{"id":35168265,"type":"split","__mediaType__options":["image","video"],"__option_inset":false,"__option_primary_modal":false,"__option_headline":false,"__option_flip":false,"__option_secondary_image":true,"__option_caption":false,"media":[{"src":"eef146b3-d82f-45e0-bda9-0f93ddeff1e3","credits":{},"altText":""}],"headline":"Lorem Ipsum","primaryCopy":"The manual covers techniques for fighting against several different weapons that one might encounter in a duel. This detail shows how to defend against an opponent that has both a rapier and a dagger. Expand the video to see how a dagger is used to \"bind\" a blade.","imglink":{"type":"imagelink","src":{"src":"d1c87d51-6737-4830-92d8-eb4dc35bc1cd","credits":{},"altText":""},"modalReference":"18834440","caption":"Vivamus interdum suscipit leo, non suscipit purus dignissim quis."},"primaryimglink":{"modalReference":""},"modals":[{"__option_autoplay":true,"__option_controls":true,"__option_inset":false,"__option_caption":false,"__option_loop":false,"id":"18834440","__mediaType":"video","src":["374d0008-5b8c-4e9b-a08d-affddc137355"],"caption":"This is an example caption","poster":"f48d52b9-4756-4a62-a490-4b230c93f628"}],"seamlessAsset":{"assetID":"76796179","frame":1,"x":-1.1333314387991424,"y":-6.69272060588672,"scale":0.6596},"assetType":"standard","__option_secondary_modal":true,"__mediaType":"image","moduleTitle":"Rapier Example","exhibitionId":"114","isActive":true,"experienceID":"563","experienceType":"LABEL","colorCode":"#3D4DCC","bgColorCode":"#f7f7f7","vScalePercent":0.568359375,"src":[]},{"id":63219798,"type":"split","__mediaType__options":["image","video"],"__option_inset":false,"__option_primary_modal":false,"__option_headline":false,"__option_flip":false,"__option_secondary_image":true,"__option_caption":false,"media":[{"src":"f3f36940-ed4c-457d-a58d-54461df571de","credits":{},"altText":""}],"headline":"Lorem Ipsum","primaryCopy":"This engraving depicts one opponent raising his left hand to parry or block the other's blade. While doing this bare handed might be worth the risk, special \"dueling\" gauntlets were designed for this purpose, as in the mid 16th-century example in this display.","imglink":{"type":"imagelink","src":{"src":"2f41ed46-4aea-4b99-a3bb-9dee428ebbae","credits":{},"altText":""},"modalReference":"","caption":"Vivamus interdum suscipit leo, non suscipit purus dignissim quis."},"primaryimglink":{"modalReference":""},"modals":[],"seamlessAsset":{"assetID":null,"frame":1,"x":0,"y":0,"scale":1},"assetType":"standard","__option_secondary_modal":false,"__mediaType":"image","src":[],"moduleTitle":"Gauntlet Intro","exhibitionId":"114","isActive":true,"experienceID":"563","experienceType":"LABEL","colorCode":"#3D4DCC","bgColorCode":"#f7f7f7","vScalePercent":0.9658203125},{"id":313001,"type":"tooltip","media":"","title":"Back of glove","hotspots":[{"x":36.11930612206508,"y":36.301358404710925,"content":"This dent is likely from a heavy blow of a sword blade.","id":1},{"x":80.90471875871972,"y":49.36345690578159,"content":"These scales face backwards so that a sword would glide across and not get caught","id":2}],"seamlessAsset":{"assetID":"24108049","frame":14,"x":-2.9259259420554535,"y":3.686635500007398,"scale":0.5361},"assetType":"seamless","__option_object_title":true,"__mediaType":null,"moduleTitle":"Gauntlet 1","exhibitionId":"114","isActive":true,"experienceID":"563","experienceType":"LABEL","colorCode":"#3D4DCC","bgColorCode":"#f7f7f7","vScalePercent":0.9658203125,"poster":"43248a09-6c3c-49c1-83a7-44013ae3c793"},{"id":33471848,"type":"tooltip","media":"","title":"Palm of glove","hotspots":[{"x":68.86562934026418,"y":45.937332708779444,"content":"The palm of the hand is covered in mail to allow the wearer to push away or grip an opponent's sharp blade","id":1},{"x":8.670182247986432,"y":44.65253613490364,"content":"This is a remnant of a leather strap for fastening to a sleeve or padded coat.&nbsp;","id":2}],"seamlessAsset":{"assetID":"24108049","frame":42,"x":-8.07407398696211,"y":5.5957866969649945,"scale":0.6372},"assetType":"seamless","__option_object_title":true,"__mediaType":null,"moduleTitle":"Gauntlet 2","exhibitionId":"114","isActive":true,"experienceID":"563","experienceType":"LABEL","colorCode":"#3D4DCC","bgColorCode":"#f7f7f7","vScalePercent":0.9658203125},{"id":32158825,"type":"interstitial","title":"Example Title","media":{"src":"23b3a662-5f0b-4d07-9c6c-f3f265680b74","credits":{},"altText":""},"copy":"The Academy of the Sword represents Thibault's life work and captures the spirit of the era.","headline":"Example Headline","__option_headline":false,"__option_body_copy":true,"__option_section_title":false,"__option_background_image":true,"seamlessAsset":{"assetID":"72484837","frame":1,"x":17.862369971880884,"y":-46.28906082850506,"scale":1.5847},"assetType":"seamless","__mediaType":null,"moduleTitle":"Conclusion","exhibitionId":"114","isActive":true,"experienceID":"563","experienceType":"LABEL","colorCode":"#3D4DCC","bgColorCode":"#f7f7f7","vScalePercent":0.9658203125},{"id":14004444,"headline":"The End","copy":"Start from the beginning?","button":"Start Over","modalReference":"48592899","__option_credits":true,"modals":[{"id":"48592899","subhead":"Thank You","copy":"This is some copy for the exhibition credits page.","__option_subhead":false,"__option_copy":false,"__option_media":true,"media":[{"src":"162dcbe8-7aee-429a-99e6-a799bf6d95d6","credits":{},"altText":""}]}],"seamlessAsset":{"assetID":"72484837","frame":1,"x":0,"y":-10.25390625,"scale":2},"type":"end","media":{"src":"257f730c-f381-496f-854b-43e3f4744795","credits":{},"altText":""},"__option_background_image":true,"__mediaType":null,"assetType":"seamless","moduleTitle":"","exhibitionId":"114","isActive":true,"experienceID":"563","experienceType":"LABEL","colorCode":"#3D4DCC","bgColorCode":"#f7f7f7","vScalePercent":0.880859375}]
        </script>
        <script type="application/json" data-closerLook-assetLibrary>
            [{"type":"sequence","title":"Magic Circle","id":"45844182", "width": 683, "height": 1024, "src":[{"src":"0a2fe150-b1fa-4781-876b-cc04abcebd8b","frame":0},{"src":"99f8f048-d690-4a64-918e-4602c0441950","frame":1},{"src":"4f792c29-d0dc-4687-967c-d2227f7fa571","frame":2},{"src":"cc8db0ff-cef5-44fb-ac68-634a245d5f65","frame":3},{"src":"89baa843-8548-46f9-8ef0-bb17a809e7ab","frame":4},{"src":"0bbc2f83-4018-4b1c-a0af-bc04e7445cf3","frame":5},{"src":"23d68106-81a8-4312-928e-50e4cb05b533","frame":6},{"src":"0df59568-ff9a-48f2-b1b4-29cd5e2abb6f","frame":7}]},{"type":"sequence","title":"Author CallOut","id":"31110133", "width": 3000, "height": 4168, "src":[{"src":"31c062d2-0058-4978-a4a4-32b3017dc0ea","frame":0},{"src":"a7bcba07-3426-4fdd-af86-db6c5e19304d","frame":1},{"src":"e23c6f4d-a8e2-4940-bdcc-18e133c86418","frame":2},{"src":"5fa63c69-2fe5-40ea-bbad-32f479f4aed7","frame":3},{"src":"57e74e28-23a4-4ce7-82de-eba2d00591d9","frame":4},{"src":"de8bee9b-86b2-4ffe-9e1e-8aa52bc76fb3","frame":5},{"src":"ecf563aa-9ae6-4b91-8809-b8a7c05bedb1","frame":6},{"src":"c96f4eba-1296-47ce-a2f0-74888618d318","frame":7},{"src":"d1d14d28-a855-4737-9d0a-5440c3e0ec02","frame":8},{"src":"ac49a66b-21e1-45fe-9503-a8473c2e9d5e","frame":9},{"src":"7fd638ec-2408-45a0-8d5c-387835a56d9c","frame":10},{"src":"474ce8b1-e10a-47ae-aca8-31e53472a07f","frame":11},{"src":"0c303dbc-1256-4d70-bcf7-dfe0d56e2c23","frame":12},{"src":"e62b7691-e0fd-44c9-9936-4de176cac673","frame":13},{"src":"aa9a56e3-7799-4463-a375-155df7536589","frame":14},{"src":"c3d37ca6-195a-4578-a289-26febe4d6bc3","frame":15},{"src":"0b5ad9f2-2a7b-48c2-b825-96e168078a74","frame":16},{"src":"7fa8142c-afb9-42c7-9af2-fb476b347187","frame":17},{"src":"a952343e-704d-42d3-92fa-ae1b7e2d7d19","frame":18},{"src":"66d192a0-3bc0-4397-a674-a72116af1f07","frame":19},{"src":"de2a9a96-0b2d-492e-9163-6cb1d91c5dad","frame":20},{"src":"50e28003-fd7f-4234-9bdd-a0700e3c800f","frame":21},{"src":"2c290028-3a71-451b-a100-ca84c010bddd","frame":22},{"src":"7deb0837-4265-4ca8-ae1f-82dd1fd51e55","frame":23}]},{"type":"sequence","title":"Art Of Defense Animation","id":"81030626","src":[]},{"type":"image","title":"Author _end","id":"72484837","width": 683, "height": 1024, "src":["3cf66812-d0f8-4502-80b7-b21d47fd89a7"]},{"type":"sequence","title":"Gauntlet","id":"24108049", "width": 2700, "height": 1519, "src":[{"src":"181fb35e-0956-4ffd-8d49-2eedb32c41e5","frame":0},{"src":"4ba7956c-67d1-4970-ab04-358a49574ed4","frame":1},{"src":"7c4e617a-c48a-4321-ae0a-2533f0ba1360","frame":2},{"src":"62d8158c-e0cf-4f9b-bbf7-433abc9cdc13","frame":3},{"src":"74d74010-f66c-45fe-a762-d8999726fd14","frame":4},{"src":"3cff6476-a03a-48c1-b47a-8ce97d82d705","frame":5},{"src":"4034aaf1-f5a2-4ceb-aa84-df5f69bf22a5","frame":6},{"src":"bf05b294-47b5-4005-80f1-e7822c9536fc","frame":7},{"src":"d7b5fda8-bbc1-42c3-9682-07722ae5e283","frame":8},{"src":"ef35c07b-9f21-4a4e-ace5-66460445aa89","frame":9},{"src":"966e0cfd-566a-40db-826b-c13a334e4116","frame":10},{"src":"c0b1d549-ef7e-432c-8f3b-c37f24e8ed5e","frame":11},{"src":"b2326e01-a6db-4f9c-bd18-b5565e9b54d5","frame":12},{"src":"6e8c5173-af40-40a7-822a-4737013e1ce0","frame":13},{"src":"babcf529-82b9-4027-bd48-7a15ae690205","frame":14},{"src":"fe7f5155-ca47-451b-9f0b-fa1bb4af757d","frame":15},{"src":"93857c75-9731-4d8b-97b8-e8aad5f5db84","frame":16},{"src":"76a3f7cb-9b4a-49ab-9e79-f4b9927165fd","frame":17},{"src":"42735473-c2e8-41d8-b5d8-126e9ff4745e","frame":18},{"src":"aa936e93-101e-4996-9956-15f8382f2fbd","frame":19},{"src":"a568f5c8-55f9-4691-a0b4-61d08c754410","frame":20},{"src":"57e1c28b-7158-414c-a1e6-3b5ab5662fc6","frame":21},{"src":"9699f1b3-c124-4514-98cd-96d8c7265a61","frame":22},{"src":"1d16ef84-6ae1-4a50-b9bd-df4773958237","frame":23},{"src":"07a2a2d1-c375-4e25-a477-0af6a9433625","frame":24},{"src":"dfacd0cc-2972-4618-8391-c6948f685bb2","frame":25},{"src":"98c90726-66b5-4592-bf92-4148d7058ded","frame":26},{"src":"f0ab8ee2-14ad-491a-8c19-6dbd1ce409cd","frame":27},{"src":"2bada28d-a1b3-468f-a66e-5c4a269c5bc6","frame":28},{"src":"7ae614a3-cce5-49a3-9688-ffa9981ebe3c","frame":29},{"src":"4316df81-1409-4ad2-b719-838f597907af","frame":30},{"src":"13f06b24-1442-48a9-b55b-a6a6a92c83dd","frame":31},{"src":"4978a3c4-d446-40e7-b0af-d011a054e0d2","frame":32},{"src":"1d0c73fa-a35e-4973-8af1-fef3e17871c8","frame":33},{"src":"c405af0a-1583-4423-b1df-524342a06e6b","frame":34},{"src":"d1c85d93-b95e-4915-9688-21b1bb0c075b","frame":35},{"src":"393660e0-dc8d-49ed-baa0-06e5bc8f9419","frame":36},{"src":"3ee22caa-c7c6-4e3b-8004-540d25c6281e","frame":37},{"src":"3813182c-d273-4c01-9a95-7be2ce454062","frame":38},{"src":"03212bd4-49b7-4a85-b771-0a9900eff7ae","frame":39},{"src":"344547a5-3aeb-44c0-98a7-eb4f878f948f","frame":40},{"src":"c8713501-4be8-490d-a000-44149ad54e7c","frame":41},{"src":"52afa456-78b9-4bc8-ae1b-8b9aba04f6bc","frame":42},{"src":"8e199a45-e8f9-443a-b8a5-6d30bcd7ffc3","frame":43},{"src":"f6576265-4c51-477c-8256-4a04f95b7632","frame":44},{"src":"e5c9ddfd-e7f1-4bbf-8e9e-8d0222f47c37","frame":45},{"src":"58236b96-b64c-4054-9a4b-38dd7eee2f52","frame":46},{"src":"3006965d-62b5-4563-88e8-801b36c4fd2b","frame":47},{"src":"ad104326-cb1d-498b-9a29-cd6bc4eb7b42","frame":48},{"src":"bc90966d-04bb-48cc-81e8-5ae43c11f8d7","frame":49},{"src":"ba2f456a-acb3-4cee-83e2-3eaee5c911ea","frame":50},{"src":"ff16d96a-d8e2-4f28-8547-7a46d7198da6","frame":51},{"src":"1931c4aa-64ff-4436-b079-2953abb9680b","frame":52},{"src":"b65193cd-5131-4008-affc-5a402f362a07","frame":53},{"src":"2dfbb8e2-d4ff-4b7e-8c0d-b1eb7a7b26e9","frame":54},{"src":"ecd867d1-cb72-4293-82e4-bc06aaca866c","frame":55},{"src":"c0eab326-a625-41d0-a91a-c38596be8d05","frame":56},{"src":"550fdb92-78ef-448b-ac69-000dc0fc2fce","frame":57},{"src":"742283c3-7711-4504-a838-360e6be875af","frame":58},{"src":"41768d7d-e555-4838-bfc5-95ad60a788c1","frame":59},{"src":"e2c33f4d-531c-4d7d-ad52-3fef2c87c382","frame":60},{"src":"f97d48ae-a213-4ca8-b161-d9f7dec314bb","frame":61},{"src":"c698c26f-629e-4faa-a221-08b54d3b1d2e","frame":62},{"src":"ccd5fa98-aa7d-4b66-9d70-453120ae92b7","frame":63},{"src":"4198b8d0-4c30-44f1-b345-257d9701a23a","frame":64},{"src":"6e1ea1db-f90b-4f91-bbec-95b8414374a7","frame":65},{"src":"a322e400-9c8b-4a7b-9227-9c62a98430f2","frame":66},{"src":"18b70a22-acc8-44db-8b59-363b3aee958a","frame":67},{"src":"07a6d214-aaa6-48f8-8f02-9c5cc18bb6c7","frame":68},{"src":"bafd3f92-f56c-4850-b58c-f42ee09174ca","frame":69},{"src":"6c73e73e-8735-4d38-860e-ddd172d5da70","frame":70},{"src":"4f5de957-7b0d-46fe-a281-ba89aa362823","frame":71}]}]
        </script>
    </section> --}}

    {{-- <section>
        @component('components.molecules._m-title-bar')
            Further Reading
        @endcomponent
        @component('components.organisms._o-grid-listing')
            @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows')
            @slot('cols_medium','3')
            @slot('cols_large','4')
            @slot('cols_xlarge','4')
            @slot('behavior','dragScroll')
            @foreach ($furtherReading as $item)
                @component('components.molecules._m-listing----article')
                    @slot('item', $item)
                    @slot('imageSettings', array(
                        'fit' => 'crop',
                        'ratio' => '16:9',
                        'srcset' => array(200,400,600),
                        'sizes' => aic_imageSizes(array(
                            'xsmall' => '216px',
                            'small' => '216px',
                            'medium' => '18',
                            'large' => '13',
                            'xlarge' => '13',
                        )),
                    ))
                @endcomponent
            @endforeach
        @endcomponent
    </section> --}}

@endsection
