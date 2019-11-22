//get quiz id from start.php file
let id = document.getElementById('id').value;
let lastQuestion = document.getElementById('last_question').value;

// ajax type GET , getting up questions and answer tables data and parse by json
$.ajax({

    type: "GET",
    url: `/quiz/start?id=${id}`,
    data: {_csrf: yii.getCsrfToken()},
    dataType: "json",

    success: function (data) {

        data = JSON.parse(data);

        startQuiz(data);

    },

    error: function (response, status) {

        alert("Failed");

    }
});

//startQuiz is main function which units other functions

function startQuiz(data) {

    let nextBtn = document.getElementById('next');
    nextBtn.addEventListener('click', nextPage);

    let prevBtn = document.getElementById('prev');
    prevBtn.addEventListener('click', prevPage);

    let currentPage = lastQuestion;

//here is prevPage and nextPage functions which defines the action after click previous and next button

    function prevPage() {

        if (this.hasAttribute('disabled')) {
            return;
        }

        chooseOption(false);

        currentPage--;
        changePage(currentPage);

        checkedAnswer();

    }


    function nextPage() {

        if (this.hasAttribute('disabled')) {
            return;
        }

        chooseOption(true);

        currentPage++;
        changePage(currentPage);

        checkedAnswer();

    }

//chooseOption get value from input and ajax POST type request, connect QuizController's actionProgress and will save data in progress table

    function chooseOption(is_next) {
        let chooseAnswer;

        if (document.querySelector('input[name = "option"]:checked') != null) {
            chooseAnswer = document.querySelector('input[name = "option"]:checked').value;
        } else {
            chooseAnswer = null;
        }
        console.log(is_next);

        $.ajax({

            type: "POST",
            url: "/quiz/progress",
            data: {
                selected_answer: chooseAnswer,
                last_question: currentPage,
                is_next: (is_next) ? 1 : 0,
                quiz_id: id,
                question_id: data[currentPage - 1].id,
                _csrf: yii.getCsrfToken()
            },

            success: function (data) {

                // console.log('Success')

            },

            error: function (response, status) {

                console.log("Failed");

            }
        });
    }

//checkedAnswer is for a radio buttons checked visualisation

    function checkedAnswer() {

        $.ajax({

            type: "GET",
            url: "/quiz/progress",
            data: {_csrf: yii.getCsrfToken()},
            dataType: "json",

            success: function (progressData) {

                progressData = JSON.parse(progressData);

                try {
                    for (let i = 0; i < 1; i++) {
                        for (let j = 0; j < data[i].max_ans; j++) {

                            let selectedAnswer = document.getElementsByClassName('selectedAnswer')[j].value;

                            for (let k = 0; k < progressData.length; k++) {

                                if (selectedAnswer) {
                                    if (selectedAnswer == progressData[k].selected_answer) {

                                        document.getElementsByClassName('selectedAnswer')[j].checked = true;

                                    }
                                }
                            }

                        }
                    }
                } catch (e) {
                    if (e) {
                        let selectedAnswer = document.getElementsByClassName('selectedAnswer').value;
                    }
                }

                console.log(progressData);

            },

            error: function (response, status) {

                console.log("Failed");

            }
        });
    }

    function changePage(page) {

        let submitBtn = document.getElementById('submit');
        submitBtn.onclick = function () {
            chooseOption(true);
            setTimeout(function () {
                location.href = `/quiz/outcome?id=${id}`;
            }, 0.0001);
        };

        for (let i = (page - 1); i < page; i++) {

            let outputAnswer = '';
            let outputQuestion = '';
            let result = '';

            outputQuestion += '<label style="font-size:30px;margin-left:30px;color:#23527c">' +
                data[i].name +
                '</label>';

            for (let j = 0; j < data[i].answers.length; j++) {
                outputAnswer +=
                    '<div class="radio">' +
                    '<label style="font-size:20px;text-align:left;margin-left:60px;">' +
                    '<input class="selectedAnswer" type="radio" name="option" value="' + data[i].answers[j].id + '">' +
                    data[i].answers[j].name +
                    '</label>' +
                    '</div>';
            }

            result += outputQuestion +
                '<br>' +
                outputAnswer +
                '<div class="form-group" style="margin-left:30px">' +
                '</div>';

            document.getElementById('result').innerHTML = result;

        }

        if (page == 1) {
            submitBtn.style.visibility = 'hidden';
            prevBtn.className = 'btn btn-secondary';
            prevBtn.setAttribute('disabled', 'true');
        } else {
            prevBtn.removeAttribute('disabled');
            prevBtn.className = 'btn btn-danger';
            submitBtn.style.visibility = 'hidden';
        }

        if (page == data.length) {
            submitBtn.style.visibility = 'visible';
            nextBtn.className = 'btn btn-secondary';
            nextBtn.setAttribute('disabled', 'true');

        } else {
            nextBtn.removeAttribute('disabled');
            nextBtn.style.visibility = 'visible';
            submitBtn.style.visibility = 'hidden';
            nextBtn.className = 'btn btn-success';
        }
    }

    window.onload = function () {
        changePage(lastQuestion);
        checkedAnswer();
    };

    console.log(data);
}
