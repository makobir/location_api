## ** 📘 Location API Documentation **

This API provides location data such as divisions, districts, upazilas, unions, and villages. It supports both **authorized dependent dropdown fetching** and **public name retrieval** for a specific ID.

---

## 🔐 1. Authorized Endpoint (For Dependent Dropdowns)

**Endpoint:**
```
GET https://makobir.com.bd/location/get/{type}/{parent_id}
```

### Allowed Types and Use:
| Type       | Description             | parent_id Meaning      |
|------------|--------------------------|-------------------------|
| divisions  | All divisions            | N/A (can be 0/null)     |
| districts  | Districts of a division  | Division ID             |
| upazilas   | Upazilas of a district   | District ID             |
| unions     | Unions of an upazila     | Upazila ID              |
| villages   | Villages of a union      | Union ID                |

### 🔐 Required Headers:
```http
X-API-KEY: your_api_key
X-API-DOMAIN: your_website.com
```

### ✅ Example Request:
```bash
curl -H "X-API-KEY: abcd1234" -H "X-API-DOMAIN: example.com"      https://makobir.com.bd/location/get/districts/1
```

### ✅ Example Response:
```json
{
  "status": true,
  "data": [
    {"id": 1, "name_en": "Dhaka", "name_bn": "ঢাকা"},
    {"id": 2, "name_en": "Gazipur", "name_bn": "গাজীপুর"}
  ]
}
```

---

## 🌍 2. Public Endpoint (Get Name by ID)

No API key required — allows client systems to retrieve a **single location name** based on type and ID.

**Endpoint:**
```
GET https://makobir.com.bd/location/names/{type}/{id}
```

### Allowed Types:
- division
- district
- upazila
- union
- village

### ✅ Example Request:
```
GET https://makobir.com.bd/location/names/division/1
```

### ✅ Example Response:
```json
{
  "status": true,
  "type": "division",
  "id": 1,
  "name_en": "Dhaka",
  "name_bn": "ঢাকা"
}
```

### ❌ Error Response:
```json
{
  "status": false,
  "message": "Data not found."
}
```

---

## ⚙️ Integration Examples:

### PHP Example:
```php
$response = file_get_contents("https://makobir.com.bd/location/names/upazila/5");
$data = json_decode($response, true);
echo $data['name_bn']; // অথবা $data['name_en']
```

### JavaScript (Fetch):
```javascript
fetch('https://makobir.com.bd/location/names/union/12')
  .then(res => res.json())
  .then(data => console.log(data.name_bn));
```

### Python (Requests):
```python
import requests
res = requests.get("https://makobir.com.bd/location/names/village/99")
print(res.json()["name_bn"])
```

---

## 📌 Notes:
- Ensure your CodeIgniter `.htaccess` and routing is properly set.
- No CORS restriction for public name endpoint. Consider adding `Access-Control-Allow-Origin: *`.
- Public name route is useful when you have only IDs saved and want to show readable names.
- Both `name_en` and `name_bn` are available for multilingual support.

---

For issues or further integration support, contact: **makobirbd@gmail.com** ✅
