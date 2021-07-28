$(document).on('change', '#annonces_departement, #annonces_commune, #annonces_arrondissement', function() {
    let $field = $(this)
    let $departementField = $('#annonces_departement')
    let $communeField = $('#annonces_commune')
    let $token = $('#annonces__token')
    let $form = $field.closest('form')
    let target = '#' + $field.attr('id').replace('arrondissement', 'quartier').replace('commune', 'arrondissement').replace('departement', 'commune')
    let data = {}
    data[$token.attr('name')] = $token.val()
    data[$departementField.attr('name')] = $departementField.val()
    data[$communeField.attr('name')] = $communeField.val()
    data[$field.attr('name')] = $field.val()
    $.post($form.attr('action'), data).then(function(data) {
        let $input = $(data).find(target)
        $(target).replaceWith($input)
    })
})