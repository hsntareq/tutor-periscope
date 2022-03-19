import { existsSync } from "fs";

const submit_assignment = document.getElementById('submit_assignment');
const course_assignment = document.getElementById('course_assignment');

course_assignment.onsubmit = (e) => {
    e.preventDefault();
    console.log(this);

    var formData = new FormData();
    formData.append('action', 'periscope_course_assignment');
    formData.append(_tutorobject.nonce_key, _tutorobject._tutor_nonce);
    const xhttp = new XMLHttpRequest();
    xhttp.open('POST', _tutorobject.ajaxurl, true);
    xhttp.send(formData);
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState === 4) {
            let historyData = JSON.parse(xhttp.response);
            historyData = historyData.data;
            // console.log(historyData);

            // console.log(Object.entries(historyData));

            tutor_option_history_load(Object.entries(historyData));
            delete_history_data();
        }
    };
}