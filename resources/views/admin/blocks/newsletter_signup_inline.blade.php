@formField('select', [
    'name' => 'list',
    'label' => 'Newsletter target list',
    'options' => \App\Models\ExactTargetList::getList()
])
