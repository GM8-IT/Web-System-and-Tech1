<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Form</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>BIO-DATA</h1>
    <form action="biodata.php" method="post" enctype="multipart/form-data">
      <div class="photo-box">
        <label for="photo">1x1 Picture</label>
        <input type="file" name="photo" id="photo" accept="image/*" required>
      </div>

      <h2>Personal Data</h2>
      <div class="grid">
        <label>Position Desired: <input type="text" name="position"></label>
        <label>Date: <input type="date" name="date"></label>
        <label>Name: <input type="text" name="name"></label>
        <label>Gender: 
          <select name="gender">
            <option>Male</option>
            <option>Female</option>
          </select>
        </label>
        <label>City Address: <input type="text" name="city_address"></label>
        <label>Provincial Address: <input type="text" name="prov_address"></label>
        <label>Telephone: <input type="text" name="telephone"></label>
        <label>Cellphone: <input type="text" name="cellphone"></label>
        <label>Email: <input type="email" name="email"></label>
        <label>Date of Birth: <input type="date" name="dob"></label>
        <label>Birth Place: <input type="text" name="birthplace"></label>
        <label>Citizenship: <input type="text" name="citizenship"></label>
        <label>Civil Status: <input type="text" name="status"></label>
        <label>Height: <input type="text" name="height"></label>
        <label>Religion: <input type="text" name="religion"></label>
        <label>Weight: <input type="text" name="weight"></label>
        <label>Spouse: <input type="text" name="spouse"></label>
        <label>Occupation: <input type="text" name="spouse_occ"></label>
        <label>Name of Children: <input type="text" name="children"></label>
      </div>

      <h3>Parents</h3>
      <label>Father’s Name: <input type="text" name="father"></label>
      <label>Occupation: <input type="text" name="father_occ"></label>
      <label>Mother’s Name: <input type="text" name="mother"></label>
      <label>Occupation: <input type="text" name="mother_occ"></label>
      <label>Language/Dialect: <input type="text" name="language"></label>
      <label>Emergency Contact: <input type="text" name="emergency"></label>
      <label>Contact Number: <input type="text" name="emergency_contact"></label>

      <h2>Educational Background</h2>
      <label>Elementary: <input type="text" name="elem"></label>
      <label>Year Graduated: <input type="text" name="elem_year"></label>
      <label>High School: <input type="text" name="hs"></label>
      <label>Year Graduated: <input type="text" name="hs_year"></label>
      <label>College: <input type="text" name="college"></label>
      <label>Year Graduated: <input type="text" name="college_year"></label>
      <label>Degree Received: <input type="text" name="degree"></label>
      <label>Special Skills: <input type="text" name="skills"></label>

      <h2>Employment Record</h2>
      <label>Company Name: <input type="text" name="company1"></label>
      <label>Position: <input type="text" name="position1"></label>
      <label>From: <input type="text" name="from1"></label>
      <label>To: <input type="text" name="to1"></label>
      <label>Company Name: <input type="text" name="company2"></label>
      <label>Position: <input type="text" name="position2"></label>
      <label>From: <input type="text" name="from2"></label>
      <label>To: <input type="text" name="to2"></label>

      <h2>Character Reference</h2>
      <label>Name: <input type="text" name="ref1"></label>
      <label>Company: <input type="text" name="ref1_company"></label>
      <label>Position: <input type="text" name="ref1_pos"></label>
      <label>Contact: <input type="text" name="ref1_contact"></label>
      <label>Name: <input type="text" name="ref2"></label>
      <label>Company: <input type="text" name="ref2_company"></label>
      <label>Position: <input type="text" name="ref2_pos"></label>
      <label>Contact: <input type="text" name="ref2_contact"></label>
      <h2></h2>
      <label>Res. Cert. No.: <input type="text" name="res_cert"></label>
      <label>Issued At: <input type="text" name="issued_at"></label>
      <label>Issued On: <input type="date" name="issued_on"></label>
      <label>SSS No.: <input type="text" name="sss"></label>
      <label>TIN: <input type="text" name="tin"></label>
      <label>NBI No.: <input type="text" name="nbi"></label>
      <label>Passport No.: <input type="text" name="passport"></label>

      <div class="submit-btn">
        <button type="submit">Submit</button>
      </div>
    </form>
  </div>
</body>
</html>
