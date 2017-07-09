jQuery(function ($) {
    jQuery('document').ready(function ($) {
        if(typeof _paq !== 'undefined') {
            _paq.push(['trackEvent', 'Quiz', 'Unique Visitor']);
        }

        // Simple AJAX listeners
        $(document).bind("ajaxSend", function () {
            $('.btn-primary').attr('disabled', 'disabled');
        }).bind("ajaxComplete", function () {
            $('.btn-primary').removeAttr('disabled');
        });

        // Start quiz
        updateProgressBar(1);
        $('.footer').addClass('animated fadeOutDown');
        $('.footer-quiz').addClass('animated fadeInUpBig').show();

        if(typeof _paq !== 'undefined') {
            _paq.push(['trackEvent', 'Quiz', 'Started']);
        }

        setTimeout(function () {
            $('.footer').hide();
        }, 300);
    });

    // Email Validation
    if (ChiroQuiz.platformvalidator !== undefined && ChiroQuiz.platformvalidator !== null) {
        $('#email').platform_email_validator({
            api_key: ChiroQuiz.platformvalidator,
            in_progress: function () {
                $('#email').parent().removeClass('has-warning has-error');
                $(".mailcheck-suggestion").remove();
                $("[type=submit]").addClass("disabled").attr("disabled", "disabled");
            },
            success: function (data) {
                $('#email').after(get_suggestion_str(data['is_valid'], data['did_you_mean']));
            },
            error: function () {
                $("[type=submit]").removeClass("disabled").removeAttr("disabled");
            }
        });
    }

    // Parse Mailgun Responses
    function get_suggestion_str(is_valid, alternate) {
        if (is_valid) {
            if (alternate) {
                $('#email').parent().addClass('has-warning');
                return '<div class="mailcheck-suggestion help-block">Did you mean <a href="#">' + alternate + '</a>?</div>';
            }
            if ($('#form-clicked').length) {
                $('form').unbind().submit();
                $("[type=submit]").addClass("disabled").attr("disabled", "disabled");
            } else {
                $("[type=submit]").removeClass("disabled").removeAttr("disabled");
            }

            return;
        }

        $('#email').parent().addClass('has-error');
        if (alternate) {
            return '<div class="mailcheck-suggestion help-block">This email is invalid. Did you mean <a href="#">' + alternate + '</a>?</div>';
        }
        return '<div class="mailcheck-suggestion help-block">This email is invalid.</div>';
    }

    $(".form-group").on("click", ".mailcheck-suggestion a", function (e) {
        e.preventDefault();
        $("#email").val($(this).text()).parent().removeClass('has-warning has-error');
        $("[type=submit]").removeClass("disabled").removeAttr("disabled");
        $(".mailcheck-suggestion").remove();
    });

    $('form').submit(function (e) {
        e.preventDefault();
        $(this).after('<input type="hidden" id="form-clicked" value="true">');
        $('#email').trigger('focusout');
    });

    // Allow users to go back
    $('#quiz-back').click(function () {
        previousStep();

        return false;
    });

    // styling for quiz choices
    $('.page input[type=radio]').each(function () {
        var self = $(this);
        var label = self.next();

        label.remove();
        self.iCheck({
            checkboxClass: 'icheckbox_line',
            radioClass: 'iradio_line',
            insert: '<label><i class="fa fa-fw"></i> ' + label.text() + '</label>'
        });
    });

    // progress quiz when option is picked
    $('.page input[type=radio]').on('ifClicked', function () {
        setTimeout(function () {
            nextStep()
        }, 300);

        return false;
    });

    // Show quiz results modal
    $('body').on('click', '#get-results', function () {
        $('#quiz-results').modal('show');

        if(typeof _paq !== 'undefined') {
            _paq.push(['trackEvent', 'Quiz', 'Opened Modal']);
        }

        return false;
    });

    // Submit quiz results
    $('#submit-results').click(function (e) {
        e.preventDefault();

        if (stepVerify('quiz') == 0) {
            var form = $('#chiro-quiz');
            var score = 0;

            $('input[type="radio"]:checked:not(:disabled)').each(function () {
                score += parseInt($(this).data('score'), 10);
            });

            form.append('<input type="hidden" name="score" value="' + score + '">');

            $.ajax({
                type: 'POST',
                url: ChiroQuiz.ajaxurl,
                data: form.serialize(),
                dataType: 'json',
                async: true,
                success: function (response) {
                    $('#first_name_2').val($('#first_name').val());
                    $('#email_2').val($('#email').val());
                    $('#quiz-results .modal-body').html('<h2><i class="fa fa-check-circle"></i> <br> <small>Success!</small>');
                    $('#user_id').val(response.user_id);
                    $('#quiz-back').hide();

                    setTimeout(function () {
                        $('#quiz-results').modal('hide');
                        $('#offer').html('<h2 class="quiz-completed"><i class="fa fa-check-circle"></i> <br> <strong>You scored ' + response.score + '/100</strong><br><small>' + response.feedback + '</small></h2>');
                        if (typeof $('#valuator-link').val() != 'undefined') {
                            $('#offer').html('<h2 class="quiz-completed"><i class="fa fa-check-circle"></i> <br> <strong>You scored ' + response.score + '/100</strong><br><small>' + response.feedback + '</small></h2> <a href="' + $('#valuator-link').val() + '" class="btn btn-primary btn-lg" id="show-offer">Click Here To See What Your Home Is Worth <br> <small>(Based On Official Data of Recently Sold Listings In Your Area)</small></a>');
                        }
                        $('.quiz-page').animate({'padding-top': '6%'}, 500);

                        var conversion = $('#conversion').val();
                        if (conversion != '') {
                            !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                            n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
                            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
                            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
                            document,'script','//connect.facebook.net/en_US/fbevents.js');

                            fbq('init', conversion);
                            fbq('track', 'PageView');
                            fbq('track', 'Lead');
                        }
                    }, 1000);
                }
            });
        }
    });

    function stepVerify(step) {
        $('.help-block').remove();
        $('.form-group').removeClass('has-error');
        var count = 0;

        if (step === 'quiz') {
            var inputs = ["first_name", "email"];
        } else if (step === 'offer') {
            var inputs = ["last_name", "phone", "address", "city", "state", "zip_code"];
        }

        if (inputs !== undefined) {
            jQuery.each(inputs, function (i, id) {
                if ($("#" + id).val() === '') {
                    stepError(id, 'You must enter a value.');
                    count++;
                }
            });
        }

        // Advanced Section Specific Validation
        if (step === 'basics' && count === 0) {
            var emailregex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if (!emailregex.test($('#email').val())) {
                stepError('email', 'Email address is not valid.');
                count++;
            }
        }

        function stepError(id, msg) {
            $("#" + id).parent().addClass('has-error');
            $("#" + id).after('<p class="help-block">' + msg + '</p>');
        }

        return count;
    }

    // Show quiz results
    function showResults() {
        var form = $('#chiro-quiz');
        var broker = $('#broker').val();

        $.ajax({
            type: 'POST',
            url: ChiroQuiz.ajaxurl,
            data: form.serialize(),
            dataType: 'json',
            async: true,
            success: function (response) {
                $('#quiz-back').hide();

                setTimeout(function () {
                    $('#offer').html('<h2 class="quiz-completed"><i class="fa fa-check-circle"></i> <br> <strong>You scored ' + response.score + '/100</strong></h2><h4>' + response.feedback + '<br><br><strong>You are eligible for free chirotherapy at ' + broker + '.<br>Click below for more info.</strong></h4><button class="btn btn-primary btn-lg" id="get-results">Send Me The Details!</button>');
                    $('.quiz-page').animate({'padding-top': '6%'}, 500);
                }, 1000);
            }
        });
    }

    function nextStep() {
        var active = $('.quiz-page').find('.page:visible');
        var step = active.find('.question-number').text().replace('.', '');

        if (step === '3') {
            var type = $('input[name="questions[3][answer]"]:checked').data('questions');

            if (type === 'back_pain') {
                $('.neck_pain-page, .joint-page, .migraines-page, .allergies-page').removeClass('page');
                $('.neck_pain-question, .joint-question, .migraines-question, .allergies-question').attr('disabled', 'disabled');
            } else if (type === 'neck_pain') {
                $('.back_pain-page, .joint-page, .migraines-page, .allergies-page').removeClass('page');
                $('.back_pain-question, .joint-question, .migraines-question, .allergies-question').attr('disabled', 'disabled');
            } else if (type === 'joint') {
                $('.back_pain-page, .neck_pain-page, .migraines-page, .allergies-page').removeClass('page');
                $('.back_pain-question, .neck_pain-question, .migraines-question, .allergies-question').attr('disabled', 'disabled');
            } else if (type === 'migraines') {
                $('.back_pain-page, .neck_pain-page, .joint-page, .allergies-page').removeClass('page');
                $('.back_pain-question, .neck_pain-question, .joint-question, .allergies-question').attr('disabled', 'disabled');
            } else if (type === 'allergies') {
                $('.back_pain-page, .neck_pain-page, .joint-page, .migraines-page').removeClass('page');
                $('.back_pain-question, .neck_pain-question, .joint-question, .migraines-question').attr('disabled', 'disabled');
            }
        }

        if (step != '' && typeof _paq !== 'undefined') {
            _paq.push(['trackEvent', 'Quiz', 'Answered Question', step]);
        }

        var next = active.nextAll('.page').first();
        active.removeClass('fadeIn fadeInUpBig fadeInDownBig fadeOutUpBig fadeOutDownBig').addClass('fadeOutUpBig');
        next.removeClass('fadeIn fadeInUpBig fadeInDownBig fadeOutUpBig fadeOutDownBig').addClass('animated fadeInUpBig').show();

        setTimeout(function () {
            active.hide();
        }, 500);

        if (step === '1') {
            $('#quiz-back').show();
        }

        if (step === '11' && $('#showFields').val() === 'no') {
            showResults();
        }

        if (step === '') {
            step = '0';
        }

        updateProgressBar(parseInt(step, 10) + 1);
    }

    function previousStep() {
        var active = $('.quiz-page').find('.page:visible');
        var prev = active.prevAll('.page').first();
        var step = active.find('.question-number').text().replace('.', '');

        if (step === '4') {
            var type = $('input[name="questions[3][answer]"]:checked').data('questions');

            if (type === 'back_pain') {
                $('.neck_pain-page, .joint-page, .migraines-page, .allergies-page').addClass('page');
                $('.neck_pain-question, .joint-question, .migraines-question, .allergies-question').removeAttr('disabled');
            } else if (type === 'neck_pain') {
                $('.back_pain-page, .joint-page, .migraines-page, .allergies-page').addClass('page');
                $('.back_pain-question, .joint-question, .migraines-question, .allergies-question').removeAttr('disabled');
            } else if (type === 'joint') {
                $('.back_pain-page, .neck_pain-page, .migraines-page, .allergies-page').addClass('page');
                $('.back_pain-question, .neck_pain-question, .migraines-question, .allergies-question').removeAttr('disabled');
            } else if (type === 'migraines') {
                $('.back_pain-page, .neck_pain-page, .joint-page, .allergies-page').addClass('page');
                $('.back_pain-question, .neck_pain-question, .joint-question, .allergies-question').removeAttr('disabled');
            } else if (type === 'allergies') {
                $('.back_pain-page, .neck_pain-page, .joint-page, .migraines-page').addClass('page');
                $('.back_pain-question, .neck_pain-question, .joint-question, .migraines-question').removeAttr('disabled');
            }
        }

        active.removeClass('fadeIn fadeInUpBig fadeInDownBig fadeOutUpBig fadeOutDownBig').addClass('fadeOutDownBig');
        prev.removeClass('fadeIn fadeInUpBig fadeInDownBig fadeOutUpBig fadeOutDownBig').addClass('animated fadeInDownBig').show();

        setTimeout(function () {
            active.hide();
        }, 500);

        if (step === '2') {
            $('#quiz-back').hide();
        }

        if (step === '') {
            step = '12';
        }

        updateProgressBar(parseInt(step, 10) - 1);
    }

    function updateProgressBar(step) {
        var numberOfQuestions = $('.page').length;
        if (numberOfQuestions > 17) {
            numberOfQuestions = 17;
        }

        var progress = Math.ceil((step / numberOfQuestions) * 100);

        $('.progress-percent').text(progress);
        $('.progress-bar').attr('aria-valuenow', progress).css('width', progress + '%');
    }
});
