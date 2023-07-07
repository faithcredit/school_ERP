
var PageScript = {
    _setEventListener: function() {
        $("a[href='#finish']").on('click', function() {
            var $form = $("form#ajax-reg");
            $form.validate().settings.ignore = ':disabled,:hidden';
            if($form.valid() == false) return false;

            $form.trigger('submit');
        })
    },

    _initFormValidate: function() {
        $('form#ajax-reg').validate({
            ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
            errorClass: 'validation-invalid-label',
            highlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
            },
            unhighlight: function(element, errorClass) {
                $(element).removeClass(errorClass);
            },

            // Different components require proper error label placement
            errorPlacement: function(error, element) {

                // Unstyled checkboxes, radios
                if (element.parents().hasClass('form-check')) {
                    error.appendTo( element.parents('.form-check').parent() );
                }

                // Input with icons and Select2
                else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
                    error.appendTo( element.parent() );
                }

                // Input group, styled file input
                else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
                    error.appendTo( element.parent().parent() );
                }

                // Other elements
                else {
                    error.insertAfter(element);
                }
            },
            rules: {
                email: {
                    email: true
                }
            }
        });
    },

    init: function() {
        this._initFormValidate();
        this._setEventListener();
    }
}

jQuery(function() {
    PageScript.init();
})