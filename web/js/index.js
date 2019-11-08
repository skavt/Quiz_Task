let id = document.getElementById('id');

$.ajax({

    type: "GET",

    url: "/quiz/start?id=".id,

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

function startQuiz(data) {

    let currentPage = 1;
    let selectOptions = [];

    function prevPage() {
        if (currentPage > 1) {
            currentPage--;
            changePage(currentPage);
        }
    }

    function nextPage() {
        if (currentPage < data.length) {
            currentPage++;
            changePage(currentPage);
        }
    }

    function changePage(page) {

        let nextBtn = document.getElementById('next');
        nextBtn.addEventListener('click', nextPage);
        let prevBtn = document.getElementById('prev');
        prevBtn.addEventListener('click', prevPage);
        let submitBtn = document.getElementById('submit');

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
                    '<input type="radio" name="option">' +
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
    };
    console.log(data);

}