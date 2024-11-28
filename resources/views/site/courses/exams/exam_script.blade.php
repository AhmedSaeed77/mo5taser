<script src="{{asset('ckeditor/ckeditor.js') }}"></script>

<script>
    ( function() {
        var mathElements = [
            'math',
            'maction',
            'maligngroup',
            'malignmark',
            'menclose',
            'merror',
            'mfenced',
            'mfrac',
            'mglyph',
            'mi',
            'mlabeledtr',
            'mlongdiv',
            'mmultiscripts',
            'mn',
            'mo',
            'mover',
            'mpadded',
            'mphantom',
            'mroot',
            'mrow',
            'ms',
            'mscarries',
            'mscarry',
            'msgroup',
            'msline',
            'mspace',
            'msqrt',
            'msrow',
            'mstack',
            'mstyle',
            'msub',
            'msup',
            'msubsup',
            'mtable',
            'mtd',
            'mtext',
            'mtr',
            'munder',
            'munderover',
            'semantics',
            'annotation',
            'annotation-xml',
            'mprescripts',
            'none'
        ];

        $('.ckeditor1').each( function () {

            CKEDITOR.replace( this.id , {

                extraPlugins: 'ckeditor_wiris',
                // For now, MathType is incompatible with CKEditor 4 file upload plugins.
                removePlugins: 'filetools,uploadimage,uploadwidget,uploadfile,filebrowser,easyimage',
                height: 100,
                width: '100%',
                contentsCss : 'body {overflow:hidden; text-align: end;}',
                // Update the ACF configuration with MathML syntax.
                extraAllowedContent: mathElements.join( ' ' ) + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)',
                autoParagraph: false,
            });
                CKEDITOR.config.fullPage = true;
                CKEDITOR.config.resize_enabled = true;
                CKEDITOR.config.removePlugins = 'floatingspace,panelbutton,panel,floatpanel,floating-tools,contextmenu,richcombo,resize,autogrow';
                CKEDITOR.config.readOnly = true;
                CKEDITOR.ui.dialog.select = false;
          });
        }() );
</script>

<script>
    /* slider exam */
    var currentIndex = 0,
        items = $('.single_exam_page .exam_box .question_box'),
        itemAmt = items.length,
        nextWizardStep = false;


    function cycleItems() {
        if (currentIndex > itemAmt - 1 && nextWizardStep) {
            currentIndex = itemAmt - 1;
        } else {
            var item = $('.single_exam_page .exam_box .question_box').eq(currentIndex);
            items.hide().removeClass('active');
            item.css('display', 'block').addClass('active');
            nextWizardStep = false;
        }
    }

    function deletePrev() {
        if ($('.single_exam_page .exam_box .question_box:first-of-type').hasClass('active')) {
            $('#prev').addClass('d-none')
        } else {
            $('#prev').removeClass('d-none')
        }
    }

    function deleteNext() {
        if ($('.single_exam_page .exam_box .question_box:last-of-type').hasClass('active')) {
            $('#next').addClass('d-none')
            $('#skip').addClass('d-none')
        } else {
            $('#next').removeClass('d-none')
            $('#skip').removeClass('d-none')
        }
    }



    $('#next').click(function() {

        if ($('.single_exam_page .exam_box .question_box[data-name="textual"]').hasClass('active')) {
            if ($('.question_box.active[data-name="textual"] .required_input').val() == "") {
                $('.must_answer .note').addClass('show')
                //jQuery('.questions_span span.active').removeClass('active').next('.questions_span span').addClass('active');
            } else {
                $('.must_answer .note').removeClass('show')
                nextWizardStep = true;
                currentIndex += 1;
                cycleItems();
                $('.single_exam_page .settings_box .block .questions_nums span.active').addClass('done')
                //$('.questions_span span.active').removeClass('active').next('.questions_span span').addClass('active');

            }
        } else if ($('.single_exam_page .exam_box .question_box[data-name="matching"]').hasClass('active')) {
            $('.must_answer .note').removeClass('show')
            nextWizardStep = true;
            currentIndex += 1;
            cycleItems();
            $('.single_exam_page .settings_box .block .questions_nums span.active').addClass('done')
               // $('.questions_span span.active').removeClass('active').next('.questions_span span').addClass('active');
        } else if ($('.single_exam_page .exam_box .question_box[data-name="true_false"]').hasClass('active')) {
            if ($('.question_box.active[data-name="true_false"] .required_input_check').is(':checked')) {
                $('.must_answer .note').removeClass('show')
                nextWizardStep = true;
                currentIndex += 1;
                cycleItems();
                $('.single_exam_page .settings_box .block .questions_nums span.active').addClass('done')
                //$('.questions_span span.active').removeClass('active').next('.questions_span span').addClass('active');
            } else {
                $('.must_answer .note').addClass('show')
            }
        } else if ($('.single_exam_page .exam_box .question_box[data-name="multi_choice"]').hasClass('active')) {
            if ($('.question_box.active[data-name="multi_choice"] .required_input_check').is(':checked')) {
                $('.must_answer .note').removeClass('show')
                nextWizardStep = true;
                currentIndex += 1;
                cycleItems();
                $('.single_exam_page .settings_box .block .questions_nums span.active').addClass('done')
                //$('.questions_span span.active').removeClass('active').next('.questions_span span').addClass('active');
            } else {
                $('.must_answer .note').addClass('show')
            }
        } else if ($('.single_exam_page .exam_box .question_box[data-name="true_false"]').hasClass('active')) {
            if ($('.question_box.active[data-name="true_false"] .required_input_check').is(':checked')) {
                $('.must_answer .note').removeClass('show')
                nextWizardStep = true;
                currentIndex += 1;
                cycleItems();
                $('.single_exam_page .settings_box .block .questions_nums span.active').addClass('done')
                //$('.questions_span span.active').removeClass('active').next('.questions_span span').addClass('active');
            } else {
                $('.must_answer .note').addClass('show')
            }
        } else {
            console.log('false')
        }
    });

    $('#prev').click(function() {
        if (currentIndex <= 0) {
            currentIndex = 0;

        } else if (currentIndex > 0) {
            $('.must_answer .note').removeClass('d-none')
            currentIndex -= 1;
        }
        cycleItems();
        //$('.questions_span span.active').removeClass('active').prev('.questions_span span').addClass('active');
    });

    $('#skip').click(function() {
        $('.must_answer .note').removeClass('show')
        nextWizardStep = true;
        currentIndex += 1;
        var id = $(".question_box.active").attr('id')
        $('.settings_box .numbers span[data-number="' + id + '"]').addClass('skiped')
        cycleItems();

       // jQuery('.questions_span span.active').removeClass('active').next('.questions_span span').addClass('active');
    });



    function ActiveNums() {
        var id = $(".question_box.active").attr('id')
        $('.settings_box .numbers span[data-number="' + id + '"]').addClass('active').siblings().removeClass('active')
    }



    $('.settings_box .numbers span').click(function() {

        var id = $(".question_box.active").attr('id')
        $('.settings_box .numbers span[data-number="' + id + '"]').addClass('active').siblings().removeClass('active')
        $('.question_box').not('#' + $(this).attr('data-number')).hide().removeClass('active');
        $('#' + $(this).attr('data-number')).show().addClass('active');
        console.log($(this).attr('data-number'));
        let dataId = $(this).next().attr("data-number");
        currentIndex = dataId;
        currentIndex -= 2;
        cycleItems();
    });




    setInterval(() => {
        deletePrev();
        ActiveNums();
        deleteNext();
    }, 100);



    // $(function() {
    //   $('.settings_box .numbers span').click(function() {
    //     $('.question_box').not('#' + $(this).attr('data-number')).hide().removeClass('active');
    //     $('#' + $(this).attr('data-number')).show().addClass('active');
    //   });
    // });
</script>

<script>
    function CountdownTracker(label, value) {
                var el = document.createElement('span');
                el.className = 'flip-clock__piece';
                el.innerHTML =
                    '<b class="flip-clock__card card-flip"><b class="card__top"></b><b class="card__bottom"></b><b class="card__back"><b class="card__bottom"></b></b></b>' +
                    '<span class="flip-clock__slot">' + label + '</span>';
                this.el = el;
                var top = el.querySelector('.card__top'),
                    bottom = el.querySelector('.card__bottom'),
                    back = el.querySelector('.card__back'),
                    backBottom = el.querySelector('.card__back .card__bottom');
                this.update = function(val) {
                    val = ('0' + val).slice(-2);
                    if (val !== this.currentValue) {
                        if (this.currentValue >= 0) {
                            back.setAttribute('data-value', this.currentValue);
                            bottom.setAttribute('data-value', this.currentValue);
                        }
                        this.currentValue = val;
                        top.innerText = this.currentValue;
                        backBottom.setAttribute('data-value', this.currentValue);
                        this.el.classList.remove('flip');
                        void this.el.offsetWidth;
                        this.el.classList.add('flip');
                    }
                }
                this.update(value);
            }
            // Calculation adapted from https://www.sitepoint.com/build-javascript-countdown-timer-no-dependencies/
            function getTimeRemaining(endtime) {
                var t = Date.parse(endtime) - Date.parse(new Date());
                return {
                    'Total': t,
                    'H': Math.floor((t / 1000 / 60 / 60) % 60),
                    'M': Math.floor((t / 1000 / 60) % 60),
                    'S': Math.floor((t / 1000) % 60),
                };
            }

            function getTime() {
                var t = new Date();
                return {
                    'Total': t,
                    'Hours': t.getHours() % 12,
                    'min': t.getMinutes(),
                    'sec': t.getSeconds()
                };
            }

            function Clock(countdown, callback) {
                countdown = countdown ? new Date(Date.parse(countdown)) : false;
                callback = callback || function() {};
                var updateFn = countdown ? getTimeRemaining : getTime;
                this.el = document.createElement('div');
                this.el.className = 'flip-clock';
                var trackers = {},
                    t = updateFn(countdown),
                    key, timeinterval;
                for (key in t) {
                    if (key === 'Total') {
                        continue;
                    }
                    trackers[key] = new CountdownTracker(key, t[key]);
                    this.el.appendChild(trackers[key].el);
                }
                var i = 0;

                function updateClock() {
                    timeinterval = requestAnimationFrame(updateClock);
                    // throttle so it's not constantly updating the time.
                    if (i++ % 10) {
                        return;
                    }
                    var t = updateFn(countdown);
                    if (t.Total < 0) {
                        cancelAnimationFrame(timeinterval);
                        for (key in trackers) {
                            trackers[key].update(0);
                        }
                        callback();
                        return;
                    }
                    for (key in trackers) {
                        trackers[key].update(t[key]);
                    }
                }
                setTimeout(updateClock, 500);
            }
            var TimerValue = $('.timer-number').data('value');
            var deadline = new Date(Date.parse(new Date()) + TimerValue * 60 * 1000);
            var c = new Clock(deadline, function() {
                $('#questionForm').submit();
            });
            document.querySelector('.quiz-timer').appendChild(c.el);


</script>

<script>
    $(function() {
        $('.list-group-sortable-exclude').sortable({
            placeholderClass: 'list-group-item',
            items: ':not(.disabled)'
        });
    });
</script>


{{--  exam submit form  --}}
<script>
    $(document).ready(function() {
        $('#questionForm').submit(function(e) {
            //e.preventDefault();
             var checkboxValArry1 = [];

             $(".answer_answer").each(function () {

                if($(this).data('type') == 'multi_choice' || $(this).data('type') == 'true_false')
                {
                    var input_val1 =  $(this).parents(".ques_name_box").next().find('input[type="radio"]:checked').val();
                    if(input_val1)
                    {
                        checkboxValArry1.push(input_val1)
                    }
                    if(!input_val1)
                    {
                        checkboxValArry1.push('')
                    }
                }


                if($(this).data('type') == 'textual')
                {
                    var input_val2 =  $(this).parents(".ques_name_box").next().find('.required_input').val();
                    if(input_val2)
                    {
                        checkboxValArry1.push(input_val2);
                    }
                    if(!input_val2)
                    {
                        checkboxValArry1.push('');
                    }

                }

                if($(this).data('type') == 'matching')
                {
                    var questionsArray = [];
                    var answersArray = [];
                    var matching_questions = $(this).parents(".ques_name_box").next().find(".matching_questions");
                    var matching_answers = $(this).parents(".ques_name_box").next().find(".li_ans");

                    for (var i = 0; i <= matching_questions.children().length -1; i++) {
                        var obj = {};
                        var quesContent = matching_questions.find(`.text[data-num=${i + 1}]`).text();
                        obj['qn'] = i + 1;
                        obj['q'] = quesContent;
                        questionsArray.push(obj);
                    }

                    matching_answers.each(function() {
                        var obj_2 = {};
                        var ansContent = $(this).find('.text').text();
                        var ansNum = $(this).find('.text').data("num");
                        obj_2['an'] = ansNum;
                        obj_2['a'] = ansContent;
                        answersArray.push(obj_2);
                    })

                    let final = [];

                    for (let i in questionsArray) {
                        let merged = {...questionsArray[i], ...answersArray[i]}
                        final.push( merged  )
                    }

                    checkboxValArry1.push(JSON.stringify(final));
                }


             });

             //console.log(checkboxValArry1);

             $('#true_answers').val(JSON.stringify(checkboxValArry1));
             return true;
         });
    });


    $('.finish_exam_btn').on('click',function(){
        $('#questionForm').submit();
    });

    // $(document).ready(function(){
    //   $("#next").click(function(){
    //       jQuery('.questions_span span.active').removeClass('active').next('.questions_span span').addClass('active');
    //   });

    // });


</script>
{{--  exam submit form  --}}

<script type="text/javascript" >
    function preventBack(){window.history.forward();}
    setTimeout("preventBack()", 0);
    window.onunload=function(){null};
</script>

