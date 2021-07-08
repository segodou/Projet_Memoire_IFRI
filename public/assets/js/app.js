$('form-control-file').on('change', function(e) {
    var inputFile = e.currentTarget;
    $(inputFile).parent().find('.custom-file-label').htlm(inputFile.files[0].name);
});