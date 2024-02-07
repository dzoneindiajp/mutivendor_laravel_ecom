function makeAjaxRequest(options,attributes = {}) {
    const defaultOptions = {
        method: 'post',
        data: {},
        cache: false,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function(xhr) {
            $("#loader_img").hide();
            $('.invalid-feedback').html("");
            $('.invalid-feedback').removeClass("error");
            $('.is-invalid').removeClass("is-invalid");
            if (attributes.hasOwnProperty('beforeSend') &&  typeof attributes.beforeSend === 'function'){
                attributes.beforeSend();
            }
        },
        success: function(response) {
            error_array = JSON.stringify(response);
            datas = JSON.parse(error_array);

            if (datas['status'] == 'success'){
                if (attributes.hasOwnProperty('handleSuccess') &&  typeof attributes.handleSuccess === 'function'){
                    attributes.handleSuccess();
                }
            }else{
                if(datas['status'] == 'error' && datas['errors']){
                    $.each(datas['errors'], function(index, html) {
                        let element = $("[name = " + index + "]");
                        if (element.length > 0) {
                            const elementType = element[0].tagName.toLowerCase();
                            if (elementType === 'input') {
                                let elementSubType = element[0].type;
                                
                               if(elementSubType == 'text' || elementSubType == 'password'){
                                    $("input[name = " + index + "]").addClass('is-invalid');
                                    $("input[name = " + index + "]").next().addClass('error');
                                    $("input[name = " + index + "]").next().html(html);
                                    $("input[name = " + index + "]").show();
                               }else if(elementSubType == 'radio'){
                                    $("input[name = " + index + "]").addClass('is-invalid');
                                    $("input[name = " + index + "]").next().addClass('error');
                                    $("input[name = " + index + "]").next().html(html);
                                    $("input[name = " + index + "]").show();
                               }else if(elementSubType == 'file' && element.parents('.pic-holder').length > 0){
                                // $("input[name = " + index + "]").addClass('is-invalid');
                                $("input[name = " + index + "]").parents('.pic-holder').next().addClass('error');
                                $("input[name = " + index + "]").parents('.pic-holder').next().html(html);
                                $("input[name = " + index + "]").parents('.pic-holder').next().show();
                           }
                            } else if (elementType === 'textarea' && !element.hasClass('hasCkEditor') ) {
                                $("textarea[name = " + index + "]").addClass('is-invalid');
                                $("textarea[name = " + index + "]").next().addClass('error');
                                $("textarea[name = " + index + "]").next().html(html);
                                $("textarea[name = " + index + "]").show();
                            }else if (elementType === 'textarea' && element.hasClass('hasCkEditor') ) {
                                $("textarea[name = " + index + "]").addClass('is-invalid');
                                $("textarea[name = " + index + "]").next().next().addClass('error');
                                $("textarea[name = " + index + "]").next().next().html(html);
                                $("textarea[name = " + index + "]").next().next().show();
                                
                            } else if (elementType === 'select') {
                                $("select[name = " + index + "]").addClass('is-invalid');
                                $("select[name = " + index + "]").next().next().addClass('error');
                                $("select[name = " + index + "]").next().next().html(html);
                                $("select[name = " + index + "]").next().next().show();
                            } else {
                                $("input[name = " + index + "]").addClass('is-invalid');
                                $("input[name = " + index + "]").next().addClass('error');
                                $("input[name = " + index + "]").next().html(html);
                                $("input[name = " + index + "]").show();
                            }
                        }
                        
                       
                    });
                    if (attributes.hasOwnProperty('handleErrorMessages') &&  typeof attributes.handleErrorMessages === 'function'){
                        attributes.handleErrorMessages();
                    }
                }else if(datas['status'] == 'error'){
                    
                    if (attributes.hasOwnProperty('handleError') &&  typeof attributes.handleError === 'function'){
                        attributes.handleError();
                    }else{
                        show_message(datas['msg'], 'error');
                    }
                }else if(datas['status'] == 'warning'){
                    
                    if (attributes.hasOwnProperty('handleWarning') &&  typeof attributes.handleWarning === 'function'){
                        attributes.handleWarning();
                    }else{
                        show_message(datas['msg'], 'warning');
                    }
                }else{
                    show_message(datas, 'error');
                }
                
            }

            if (attributes.hasOwnProperty('hasButton') && attributes.hasOwnProperty('btnSelector') && attributes.hasOwnProperty('btnText') ) {
                $(attributes.btnSelector).prop('disabled',false);
                $(attributes.btnSelector).html(attributes.btnText);
            }

            
        },
        error: function (xhr, status, errorThrown) {
            if(xhr.responseJSON && xhr.responseJSON.status ){
                if(xhr.responseJSON.status == 'error'){
                    errorMsg = xhr.responseJSON.msg;
                    if (attributes.hasOwnProperty('handleError') &&  typeof attributes.handleError === 'function'){
                        attributes.handleError();
                    }else{

                        show_message(xhr.responseJSON.msg, 'error');
                    }
                }else if(xhr.responseJSON.status == 'warning'){
                    errorMsg = xhr.responseJSON.msg;
                    if (attributes.hasOwnProperty('handleWarning') &&  typeof attributes.handleWarning === 'function'){
                        attributes.handleWarning();
                    }else{

                        show_message(xhr.responseJSON.msg, 'warning');
                    }
                }else{
                    show_message(xhr.responseJSON, 'error');
                }
            }else{
                show_message(xhr.responseText, 'error');
            }

            if (attributes.hasOwnProperty('hasButton') && attributes.hasOwnProperty('btnSelector') && attributes.hasOwnProperty('btnText') ) {
                $(attributes.btnSelector).prop('disabled',false);
                $(attributes.btnSelector).html(attributes.btnText);
            }
            
        }
    };

    options = { ...defaultOptions, ...options };
    // options.success = options.success || options.successCallback;
    // options.error = options.error || options.errorCallback;

    $.ajax(options);
}

// // Example of making an Ajax request with custom handlers
// const formData = new FormData(); // Create your FormData object

// const ajaxOptions = {
//     url: '{{ route("astrologer.signup") }}',
//     method: 'post',
//     data: formData,
//     successCallback: handleSuccess,
//     errorCallback: handleError
// };

// makeAjaxRequest(ajaxOptions);
