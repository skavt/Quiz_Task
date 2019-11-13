//get quiz id from start.php file
let id = document.getElementById('id').value;

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

    let currentPage = 1;

//here is prevPage and nextPage functions which defines the action after click previous and next button

    function prevPage() {
        chooseOption();

        if (currentPage > 1) {
            currentPage--;
            changePage(currentPage);
        }
        checkedAnswer(data);
    }

    function nextPage() {
        chooseOption();
        if (currentPage < data.length) {
            currentPage++;
            changePage(currentPage);
        }
        checkedAnswer(data);
    }

//chooseOption get value from input and ajax POST type request, connect QuizController's actionProgress and will save data in progress table

    function chooseOption() {
        let chooseAnswer;

        if (document.querySelector('input[name = "option"]:checked') != null) {
            chooseAnswer = document.querySelector('input[name = "option"]:checked').value;
        } else {
            chooseAnswer = null;
        }

        $.ajax({

            type: "POST",
            url: "/quiz/progress",
            data: {
                selected_answer: chooseAnswer,
                // last_question: currentPage,
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

    function checkedAnswer(data) {

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

                // console.log(progressData);

            },

            error: function (response, status) {

                console.log("Failed");

            }
        });
    }

    function changePage(page) {

        let nextBtn = document.getElementById('next');
        nextBtn.addEventListener('click', nextPage);
        let prevBtn = document.getElementById('prev');
        prevBtn.addEventListener('click', prevPage);
        let submitBtn = document.getElementById('submit');
        submitBtn.onclick = function () {
            nextPage();
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

        if (page === 1) {
            submitBtn.style.visibility = 'hidden';
            prevBtn.style.cursor = 'not-allowed';
            prevBtn.className = 'btn btn-secondary';
        } else {
            prevBtn.style.cursor = 'pointer';
            prevBtn.className = 'btn btn-danger';
            submitBtn.style.visibility = 'hidden';
        }

        if (page === data.length) {
            submitBtn.style.visibility = 'visible';
            nextBtn.style.cursor = 'not-allowed';
            nextBtn.className = 'btn btn-secondary';

        } else {
            nextBtn.style.visibility = 'visible';
            submitBtn.style.visibility = 'hidden';
            nextBtn.style.cursor = 'pointer';
            nextBtn.className = 'btn btn-success';
        }
    }

    window.onload = function () {
        changePage(1);
        checkedAnswer(data);
    };
    console.log(data);
}
