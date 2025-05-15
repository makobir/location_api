<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ডিপেন্ডেন্ট ড্রপডাউন</title>
</head>
<body>

<h2>বাংলাদেশ লোকেশন সিলেক্ট করুন:</h2>

<form method="post" action="">
    <select id="division" name="division_id" onchange="loadNext('districts', this.value)">
        <option value="">বিভাগ নির্বাচন করুন</option>
    </select>

    <select id="district" name="district_id" onchange="loadNext('upazilas', this.value)">
        <option value="">জেলা নির্বাচন করুন</option>
    </select>

    <select id="upazila" name="upazila_id" onchange="loadNext('unions', this.value)">
        <option value="">উপজেলা নির্বাচন করুন</option>
    </select>

    <select id="union" name="union_id" onchange="loadNext('villages', this.value)">
        <option value="">ইউনিয়ন নির্বাচন করুন</option>
    </select>

    <select id="village" name="village_id">
        <option value="">গ্রাম নির্বাচন করুন</option>
    </select>

    <br><br>
    <button type="submit">সাবমিট করুন</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h3>সাবমিটকৃত আইডি সমূহ:</h3>";
    echo "বিভাগ ID: " . htmlspecialchars($_POST['division_id']) . "<br>";
    echo "জেলা ID: " . htmlspecialchars($_POST['district_id']) . "<br>";
    echo "উপজেলা ID: " . htmlspecialchars($_POST['upazila_id']) . "<br>";
    echo "ইউনিয়ন ID: " . htmlspecialchars($_POST['union_id']) . "<br>";
    echo "গ্রাম ID: " . htmlspecialchars($_POST['village_id']) . "<br>";
}
?>

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
        option.textContent = item.name_bn;
        select.appendChild(option);
    });
}

(async function init() {
    const divisions = await fetchData('divisions');
    const select = document.getElementById('division');
    divisions.forEach(item => {
        const option = document.createElement('option');
        option.value = item.id;
        option.textContent = item.name_bn;
        select.appendChild(option);
    });
})();
</script>



<hr>
<?php
    $id = $_POST['district_id'];
    $json = file_get_contents("http://localhost/api_location/names/district/$id");
    $name_bn = json_decode($json, true)['name_bn'];
?>
</body>
</html>







<hr>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ডিপেন্ডেন্ট ড্রপডাউন</title>
</head>
<body>

<h2>বাংলাদেশ লোকেশন সিলেক্ট করুন:</h2>

<form method="post" action="">
    <select id="division" name="division_id" onchange="loadNext('districts', this.value)">
        <option value="">বিভাগ নির্বাচন করুন</option>
    </select>
    <input type="hidden" name="division_name_bn" id="division_name_bn">

    <select id="district" name="district_id" onchange="loadNext('upazilas', this.value)">
        <option value="">জেলা নির্বাচন করুন</option>
    </select>
    <input type="hidden" name="district_name_bn" id="district_name_bn">

    <select id="upazila" name="upazila_id" onchange="loadNext('unions', this.value)">
        <option value="">উপজেলা নির্বাচন করুন</option>
    </select>
    <input type="hidden" name="upazila_name_bn" id="upazila_name_bn">

    <select id="union" name="union_id" onchange="loadNext('villages', this.value)">
        <option value="">ইউনিয়ন নির্বাচন করুন</option>
    </select>
    <input type="hidden" name="union_name_bn" id="union_name_bn">

    <select id="village" name="village_id" onchange="setHiddenName('village', 'village_name_bn')">
        <option value="">গ্রাম নির্বাচন করুন</option>
    </select>
    <input type="hidden" name="village_name_bn" id="village_name_bn">

    <br><br>
    <button type="submit">সাবমিট করুন</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h3>আপনার নির্বাচিত লোকেশন সমূহ:</h3>";
    echo "বিভাগ: " . htmlspecialchars($_POST['division_name_bn']) . "<br>";
    echo "জেলা: " . htmlspecialchars($_POST['district_name_bn']) . "<br>";
    echo "উপজেলা: " . htmlspecialchars($_POST['upazila_name_bn']) . "<br>";
    echo "ইউনিয়ন: " . htmlspecialchars($_POST['union_name_bn']) . "<br>";
    echo "গ্রাম: " . htmlspecialchars($_POST['village_name_bn']) . "<br>";
}
?>

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
        document.getElementById(id + '_name_bn').value = '';
    });
}

function setHiddenName(selectId, hiddenId) {
    const select = document.getElementById(selectId);
    const hidden = document.getElementById(hiddenId);
    const text = select.options[select.selectedIndex]?.text || '';
    hidden.value = text;
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
        option.textContent = item.name_bn;
        select.appendChild(option);
    });

    // আগের লেভেলের নাম সেট করুন
    const parent = {
        'districts': 'division',
        'upazilas': 'district',
        'unions': 'upazila',
        'villages': 'union'
    }[type];
    if (parent) setHiddenName(parent, parent + '_name_bn');

    // নতুন select-এ onchange এ নাম সেট করুন
    select.onchange = () => {
        setHiddenName(target, target + '_name_bn');
        const nextType = {
            'district': 'upazilas',
            'upazila': 'unions',
            'union': 'villages'
        }[target];
        if (nextType) loadNext(nextType, select.value);
    };
}

// init divisions
(async function init() {
    const divisions = await fetchData('divisions');
    const select = document.getElementById('division');
    divisions.forEach(item => {
        const option = document.createElement('option');
        option.value = item.id;
        option.textContent = item.name_bn;
        select.appendChild(option);
    });
})();
</script>

</body>
</html>
