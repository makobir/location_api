<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ডিপেন্ডেন্ট ড্রপডাউন</title>
</head>
<body>

<h2>বাংলাদেশ লোকেশন সিলেক্ট করুন:</h2>

<select id="division" onchange="loadNext('districts', this.value)">
    <option value="">বিভাগ নির্বাচন করুন</option>
</select>

<select id="district" onchange="loadNext('upazilas', this.value)">
    <option value="">জেলা নির্বাচন করুন</option>
</select>

<select id="upazila" onchange="loadNext('unions', this.value)">
    <option value="">উপজেলা নির্বাচন করুন</option>
</select>

<select id="union" onchange="loadNext('villages', this.value)">
    <option value="">ইউনিয়ন নির্বাচন করুন</option>
</select>

<select id="village">
    <option value="">গ্রাম নির্বাচন করুন</option>
</select>

<script>
const API_BASE = 'http://localhost/api_location/get/';
const API_KEY = '1';
const API_DOMAIN = '2';

const headers = {
    'X-API-KEY': API_KEY,
    'X-API-DOMAIN': API_DOMAIN
};

async function fetchData(type, parentId = '') {
    const url = API_BASE + type + (parentId ? '/' + parentId : '');
    const response = await fetch(url, { headers });
    const result = await response.json();
    return result.status ? result.data : [];
}

function clearBelow(levels) {
    const ids = ['district', 'upazila', 'union', 'village'];
    ids.slice(levels).forEach(id => {
        document.getElementById(id).innerHTML = `<option value="">${id} নির্বাচন করুন</option>`;
    });
}

async function loadNext(type, parentId) {
    let target = {
        'districts': 'district',
        'upazilas': 'upazila',
        'unions': 'union',
        'villages': 'village'
    }[type];

    if (!parentId || !target) return;

    clearBelow(['districts', 'upazilas', 'unions', 'villages'].indexOf(type));

    const data = await fetchData(type, parentId);
    const select = document.getElementById(target);
    select.innerHTML = `<option value="">${target} নির্বাচন করুন</option>`;
    data.forEach(item => {
        const option = document.createElement('option');
        option.value = item.id;
        option.textContent = item.name;
        select.appendChild(option);
    });
}

(async function init() {
    const divisions = await fetchData('divisions');
    const select = document.getElementById('division');
    divisions.forEach(item => {
        const option = document.createElement('option');
        option.value = item.id;
        option.textContent = item.name;
        select.appendChild(option);
    });
})();
</script>

</body>
</html>


<?php
    $nameData = file_get_contents('http://localhost/api_location/names/division/1');
   // $nameJson = json_decode($nameData, true);
   // echo $nameJson['name']; // যেমন: ঢাকা
    echo json_decode($nameData, true)['name'];
?>