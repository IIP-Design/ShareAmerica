jQuery(document).ready(function($){

    var $addNumberBtn = $('[data-add-number-btn]');


    /* Add Number */
    $addNumberBtn.on( 'click', function(e){
        e.preventDefault();

        var $container = $(this).closest('[data-container]');

        var addNumberName = $container.find('[data-add-number-name]');
        var addNumberNameValue = addNumberName.val();

        var currentAddNumber = $container.find('[data-add-number-val]');
        var currentAddNumberValue = currentAddNumber.val();
        var currentAddNumberValueObj = currentAddNumberValue ? JSON.parse( currentAddNumberValue ) : {};

        var addNumberList = $container.find('[data-add-number-list]');

        if ( addNumberNameValue ) {
            currentAddNumberValueObj[addNumberNameValue] = addNumberNameValue;

            currentAddNumber.val( JSON.stringify( currentAddNumberValueObj ) );

            addNumberList.append('<li class="item"><span data-name="' + addNumberNameValue + '" class="name">' + addNumberNameValue + '</span><a data-remove-number-btn class="close">x</a></li>');

            addNumberName.val('');

        }

    } );


    /* Remove number */
    $(document).on( 'click', '[data-remove-number-btn]', function(e){
        e.preventDefault();

        if (! window.confirm("Are you sure?")) {
            return;
        }

        var $container = $(this).closest('[data-container]');

        var $removedAddNumber = $(this).closest('li');
        var addNumberName = $removedAddNumber.find('[data-name]').text();

        var currentAddNumber = $container.find('[data-add-number-val]');
        var currentAddNumberValue = currentAddNumber.val();
        var currentAddNumberValueObj = currentAddNumberValue ? JSON.parse( currentAddNumberValue ) : {};

        $removedAddNumber.remove();

        if ( currentAddNumberValue ) {
            if ( currentAddNumberValueObj[addNumberName] ) {
                delete currentAddNumberValueObj[addNumberName];
                currentAddNumber.val( JSON.stringify( currentAddNumberValueObj ) );
            }
        }

    } );


    /* Admin notices */
    $(document).on( 'click', '[data-sti-notice] button.notice-dismiss', function(e){
        e.preventDefault();

        var noticeName = $(this).closest('[data-sti-notice]').data('sti-notice');

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'sti-dismissNotice',
                notice: noticeName,
                _ajax_nonce: sti_ajax_object.ajax_nonce
            },
            dataType: "json",
            success: function (data) {
                console.log('Notice dismissed!');
            }
        });

    });


});