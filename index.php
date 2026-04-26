<!DOCTYPE html>
<html>
<head>
<title>Modern Student CRUD</title>

<style>
body {
    margin:0;
    font-family: 'Segoe UI';
    background: linear-gradient(135deg,#667eea,#764ba2);
    height:100vh;
}

.container {
    width:90%;
    margin:auto;
    margin-top:30px;
}

.card {
    backdrop-filter: blur(12px);
    background: rgba(255,255,255,0.15);
    padding:20px;
    border-radius:15px;
    color:white;
    margin-bottom:20px;
    box-shadow:0 8px 20px rgba(0,0,0,0.2);
}

input {
    padding:10px;
    margin:5px;
    border:none;
    border-radius:8px;
    outline:none;
}

button {
    padding:10px 15px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    background:#00c6ff;
    color:white;
    transition:0.3s;
}

button:hover {
    transform:scale(1.05);
    background:#0072ff;
}

table {
    width:100%;
    margin-top:20px;
    border-collapse: collapse;
    color:white;
}

th, td {
    padding:10px;
    text-align:center;
}

tr:hover {
    background: rgba(255,255,255,0.2);
}

.toast {
    position:fixed;
    bottom:20px;
    right:20px;
    background:black;
    color:white;
    padding:12px;
    border-radius:8px;
    display:none;
}

.delete-btn {
    background:#ff4d4d;
}

.delete-btn:hover {
    background:#cc0000;
}
</style>
</head>

<body>
<tbody id="data"></tbody>

<div class="container">

<div class="card">
<h2>Add Student</h2>
<input id="name" placeholder="Name">
<input id="email" placeholder="Email">
<input id="age" placeholder="Age">
<button onclick="addStudent()">Add</button>
</div>

<div class="card">
<h2>Students</h2>
<table>
<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Age</th>
<th>Action</th>
</tr>
</thead>
<tbody id="data"></tbody>
</table>
</div>

</div>

<div id="toast" class="toast"></div>

<script>

function showToast(msg){
    let t = document.getElementById("toast");
    t.innerText = msg;
    t.style.display="block";
    setTimeout(()=>t.style.display="none",2000);
}

function load(){
    fetch("read.php")
    .then(res => res.json())
    .then(data => {

        console.log("DATA:", data); // 👈 debug

        let rows = "";

        data.forEach(s => {

            rows += `
            <tr>
                <td>${s.id}</td>
                <td><input type="text" value="${s.name || ''}" id="name_${s.id}"></td>
                <td><input type="text" value="${s.email || ''}" id="email_${s.id}"></td>
                <td><input type="number" value="${s.age || ''}" id="age_${s.id}"></td>
                <td>
                    <button onclick="updateStudent(${s.id})">Update</button>
                    <button onclick="del(${s.id})">Delete</button>
                </td>
            </tr>`;
        });

        document.getElementById("data").innerHTML = rows;
    })
    .catch(err => console.error(err));
}

function addStudent(){
    let fd=new FormData();
    fd.append("name", document.getElementById("name").value);
    fd.append("email", document.getElementById("email").value);
    fd.append("age", document.getElementById("age").value);

    fetch("create.php",{method:"POST",body:fd})
    .then(res=>res.json())
    .then(d=>{
        showToast(d.message);
        load();
    });
}

function updateStudent(id){

    let name = document.getElementById("name_" + id).value;
    let email = document.getElementById("email_" + id).value;
    let age = document.getElementById("age_" + id).value;

    let fd = new FormData();
    fd.append("id", id);
    fd.append("name", name);
    fd.append("email", email);
    fd.append("age", age);

    fetch("update.php", {
        method: "POST",
        body: fd
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        load();
    });
}

function del(id){
    if(!id){
        showToast("Invalid ID ❌");
        return;
    }

    let fd=new FormData();
    fd.append("id", id);

    fetch("delete.php",{method:"POST",body:fd})
    .then(res=>res.json())
    .then(d=>{
        showToast(d.message);
        load();
    });
}

load();

</script>

</body>
</html>
