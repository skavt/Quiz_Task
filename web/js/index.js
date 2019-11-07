$.ajax({

    type: "GET",

    url: "/quiz/start?id=1",

    data: {_csrf: yii.getCsrfToken()},

    dataType: "json",

    success: function (data) {
        data = JSON.parse(data);

        let result = '';
        let recordPerPage = 1;
        let page = 10;

        function numPages() {
            return Math.ceil(data.length / recordPerPage);
        }

        let nextBtn = document.getElementById('next');
        let prevBtn = document.getElementById('prev');
        let submitBtn = document.getElementById('submit');

        for (let i = (page - 1) * recordPerPage; i < (page * recordPerPage); i++) {

            let outputAnswer = '';
            let outputQuestion = '';

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
                    '</div>'
            }
            result += outputQuestion +
                '<br>' +
                outputAnswer +
                '<div class="form-group" style="margin-left:30px">' +
                // '<button onclick="next()" class="btn btn-danger">Prev</button>' +
                // " " +
                // '<button onclick="next()" class="btn btn-success">Next</button>' +
                '</div>';
            if (data[i].id === '1') {
                prevBtn.disabled = true;
                prevBtn.className = 'btn btn-secondary';
                submitBtn.disabled = true;
            } else {
                prevBtn.style.visibility = 'visible';
                submitBtn.style.visibility = 'hidden'
            }
            if (page === numPages()) {
                nextBtn.disabled = true;
                nextBtn.className = 'btn btn-secondary';
                submitBtn.style.visibility = 'visible'
            } else {
                nextBtn.style.visibility = 'visible';
                submitBtn.style.visibility = 'hidden'
            }

            document.getElementById('result').innerHTML = result;
        }


        console.log(data);

    },

    error: function (response, status) {

        alert("Failed");

    }
});