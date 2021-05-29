@twillBlockTitle('Newsletter signup inline')
@twillBlockIcon('text')
@twillBlockComponent('a17-block-newsletter_signup_inline')

@formField('input', [
    'name' => 'copy',
    'label' => 'Custom copy',
    'note' => 'Override default copy',
    'maxlength' => 60
])

@formField('select', [
    'name' => 'list',
    'label' => 'Newsletter target list',
    'options' => \App\Models\ExactTargetList::getList()
])
