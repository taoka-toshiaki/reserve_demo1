let date_obj = document.querySelectorAll("td");
let submit_url = "https://example.com";
let is_date_data = [];
let cnt = 0;

date_obj.forEach(function (elm, key) {
    elm.addEventListener("mouseout", select_in_value);
    elm.addEventListener("click", sp_select_in_value);
    elm.addEventListener("touchend", sp_select_in_value);
    elm.addEventListener("dblclick", select_out_value);
});
function check_value(o, e) {
    if (is_date_data.length === 0) {
        return true;
    }
    let d = o.getAttribute("data-date");
    return d ? ((d) => {
        let f = is_date_data.find(element => {
            let pattern = new RegExp(d.split("_")[0]);
            return !element.match(pattern);
        }) ? false : true;
        if (!f) {
            select_clear(o, e);
            is_date_data = [];
            cnt = 0;
        }
        return f;
    })(d) : false;
}
function select_in_value(e) {
    if (e.buttons === 1 && check_value(this, e)) {
        if (this.getAttribute("data-date")) {
            this.style.backgroundColor = "#555";
            this.children[0].style.color = "#fff";
            if (is_date_data.indexOf(this.getAttribute("data-date")) && is_date_data.indexOf(this.getAttribute("data-date"))) {
                is_date_data[cnt] = this.getAttribute("data-date");
                cnt++;
            }
        }
    }
}
function sp_select_in_value(e) {
    if (check_value(this, e)) {
        if (this.getAttribute("data-date")) {
            this.style.backgroundColor = "#555";
            this.children[0].style.color = "#fff";
            if (is_date_data.indexOf(this.getAttribute("data-date")) && is_date_data.indexOf(this.getAttribute("data-date"))) {
                is_date_data[cnt] = this.getAttribute("data-date");
                cnt++;
            }
        }
    }
}
function select_out_value(e) {
    if (is_date_data.length) {
        let is_data = is_date_data.map(function (elm, index) {
            return "date[" + index + "]=" + elm;
        });
        window.location.href = submit_url + "?" + is_data.join("&");
    }
}
function select_clear(o, e) {
    let is_ClassName = [];
    is_ClassName = is_date_data.map(function (d) {
        return "date_" + d;
    });
    is_ClassName.map(class_name => {
        document.getElementsByClassName(class_name)[0].style.backgroundColor = "#fff";
        document.getElementsByClassName(class_name)[0].children[0].style.color = "#0d6efd";
    })
}
