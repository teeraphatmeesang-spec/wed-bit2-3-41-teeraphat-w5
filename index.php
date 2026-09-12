<?php
include 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM `character` WHERE `character_id` = $id");
    header("Location: index.php");
    exit();
}

if (isset($_POST['add'])) {
    $planet_ID = $_POST['planet_ID'];
    $Alien_Name = $_POST['Alien_Name'];
    $age = $_POST['age'];
    $power = $_POST['power'];
    $Weakness = $_POST['Weakness'];

    $conn->query("INSERT INTO `character` (planet_id, alien_Name, age, power, Weakness) 
                  VALUES ('$planet_ID', '$Alien_Name', '$age', '$power', '$Weakness')");
    header("Location: index.php");
    exit();
}

if (isset($_POST['update'])) {
    $id = $_POST['character_id'];
    $planet_ID = $_POST['planet_ID'];
    $Alien_Name = $_POST['Alien_Name'];
    $age = $_POST['age'];
    $power = $_POST['power'];
    $Weakness = $_POST['Weakness'];

    $conn->query("UPDATE `character` SET 
                  `planet_id`='$planet_ID', 
                  `alien_Name`='$Alien_Name', 
                  `age`='$age', 
                  `power`='$power', 
                  `Weakness`='$Weakness' 
                  WHERE `character_id`=$id");
    header("Location: index.php");
    exit();
}

$sql = "SELECT `character`.*, `planet`.`planet_Name`, planet.`planet_name`
        FROM `character` 
        LEFT JOIN `planet` 
        ON `character`.`planet_id` = `planet`.`planet_ID` 
        OR `character`.`planet_id` = `planet`.`planet_id`";
$result = $conn->query($sql);
$edit_row = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $edit_result = $conn->query("SELECT * FROM `character` WHERE `character_id` = $id");
    $edit_row = $edit_result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Ben 10 Character Management</title>
    <style>
        * { box-sizing: border-box; font-family: system-ui, -apple-system, sans-serif; }
        body { margin: 0; padding: 20px; background: #0f172a; color: #f8fafc; }
        .box { background: #1e293b; padding: 24px; border-radius: 12px; margin-bottom: 20px; border: 1px solid #334155; }
        .header { display: flex; justify-content: space-between; align-items: center; }
        .header h2 { margin: 0; color: #10b981; }
        
        /* จัดเรียงฟอร์ม Label อยู่ซ้าย Input อยู่ขวา ตามรูป */
        .form-group { display: flex; align-items: center; margin-bottom: 12px; }
        .form-group label { width: 140px; font-weight: bold; font-size: 15px; color: #f8fafc; flex-shrink: 0; }
        .form-group input, .form-group select { flex-grow: 1; max-width: 400px; padding: 8px 12px; border-radius: 6px; border: 1px solid #334155; background: #0f172a; color: #fff; font-size: 14px; }
        .form-group input:focus, .form-group select:focus { outline: 2px solid #10b981; }
        
        .form-actions { margin-top: 20px; padding-left: 140px; }
        .btn { padding: 8px 18px; border-radius: 6px; border: none; font-weight: bold; cursor: pointer; text-decoration: none; display: inline-block; font-size: 14px; }
        .btn-green { background: #10b981; color: #fff; }
        .btn-yellow { background: #ffc107; color: #000; }
        .btn-red { background: #ef4444; color: #fff; }
        .btn-gray { background: #64748b; color: #fff; margin-left: 6px; }
        
        table { width: 100%; border-collapse: collapse; background: #1e293b; border-radius: 12px; overflow: hidden; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #334155; }
        th { background: #0f172a; color: #94a3b8; font-size: 14px; }
        tr:hover td { background: #26334d; }
    </style>
</head>
<body>

    <div class="box header">
        <h2>Ben 10 Character Management</h2>
        <div>
            <span>ผู้ใช้: <strong><?php echo $_SESSION['user']; ?></strong></span>
            <a href="logout.php" class="btn btn-red" style="margin-left:10px;">Logout</a>
        </div>
    </div>

    <!-- ฟอร์ม Insert / Update -->
    <div class="box">
        <h3 style="margin-top:0; margin-bottom:20px;"><?php echo $edit_row ? 'แก้ไขข้อมูลตัวละคร (Update)' : 'เพิ่มข้อมูลตัวละครใหม่ (Insert)'; ?></h3>
        <form method="POST">
            <?php if ($edit_row): ?>
                <input type="hidden" name="character_id" value="<?php echo $edit_row['character_id']; ?>">
            <?php endif; ?>

            <div class="form-group">
                <label>Alien_Name:</label>
                <select name="Alien_Name" id="alien_select" onchange="autoFillData()" required>
                    <option value="">-- เลือกตัวละคร --</option>
                    <option value="Heatblast">Heatblast</option>
                    <option value="XLR8">XLR8</option>
                    <option value="Diamondhead">Diamondhead</option>
                    <option value="Four Arms">Four Arms</option>
                    <option value="Cannonbolt">Cannonbolt</option>
                    <option value="Wildmutt">Wildmutt</option>
                    <option value="Ripjaws">Ripjaws</option>
                    <option value="Grey Matter">Grey Matter</option>
                    <option value="Upgrade">Upgrade</option>
                    <option value="Stinkfly">Stinkfly</option>
                    <option value="Ghostfreak">Ghostfreak</option>
                </select>
            </div>

            <div class="form-group">
                <label>planet_ID (ดาว):</label>
                <select name="planet_ID" id="planet_select" required>
                    <option value=""> </option>
                    <?php 
                    if ($planets && $planets->num_rows > 0) {
                        while($p = $planets->fetch_assoc()) {
                            $p_id = $p['planet_ID'] ?? $p['planet_id'] ?? $p['id'] ?? '';
                            $p_name = $p['planet_Name'] ?? $p['planet_name'] ?? $p['name'] ?? '';
                            $current_p_id = $edit_row ? ($edit_row['planet_id'] ?? $edit_row['planet_ID'] ?? '') : '';
                            $selected = ($current_p_id == $p_id) ? 'selected' : '';
                            echo "<option value='".$p_id."' ".$selected.">".$p_id." - ".$p_name."</option>";
                        }
                    } else {
                        echo '<option value="1">1 - Pyros</option>';
                        echo '<option value="2">2 - Kinet</option>';
                        echo '<option value="3">3 - Petropia</option>';
                        echo '<option value="4">4 - Arburia</option>';
                        echo '<option value="5">5 - Galvan Prime</option>';
                        echo '<option value="6">6 - Tropical / Oceanic</option>';
                        echo '<option value="7">7 - Temperate / Rocky</option>';
                        echo '<option value="8">8 - Technological / Temperate</option>';
                        echo '<option value="9">9 - Tropical / Swampy</option>';
                        echo '<option value="10">10 - Dark / Cold</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>age:</label>
                <input type="number" name="age" id="age" value="<?php echo $edit_row ? $edit_row['age'] : ''; ?>" required>
            </div>

            <div class="form-group">
                <label>power:</label>
                <input type="text" name="power" id="power" value="<?php echo $edit_row ? $edit_row['power'] : ''; ?>" required>
            </div>

            <div class="form-group">
                <label>Weakness:</label>
                <input type="text" name="Weakness" id="weakness" value="<?php echo $edit_row ? $edit_row['Weakness'] : ''; ?>" required>
            </div>

            <div class="form-actions">
                <?php if ($edit_row): ?>
                    <button type="submit" name="update" class="btn btn-yellow">อัปเดตข้อมูล (Update)</button>
                    <a href="index.php" class="btn btn-gray">ยกเลิก</a>
                <?php else: ?>
                    <button type="submit" name="add" class="btn btn-green">เพิ่มข้อมูล (Insert)</button>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- ตารางแสดงข้อมูล Select -->
    <h3>รายการตัวละคร (Select)</h3>
    <div style="overflow-x: auto;">
        <table>
            <tr>
                <th>character_ID</th>
                <th>Alien_Name</th>
                <th>planet_ID (ชื่อดาว)</th>
                <th>age</th>
                <th>power</th>
                <th>Weakness</th>
                <th>การจัดการ</th>
            </tr>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <?php 
                        $alien_name  = $row['alien_Name'] ?? $row['Alien_Name'] ?? '';
                        $planet_id   = $row['planet_id'] ?? $row['planet_ID'] ?? '';
                        $planet_name = $row['planet_Name'] ?? $row['planet_name'] ?? 'ไม่ระบุ';
                        $char_id     = $row['character_id'] ?? $row['character_ID'] ?? '';
                    ?>
                    <tr>
                        <td><?php echo $char_id; ?></td>
                        <td><strong style="color:#10b981;"><?php echo $alien_name; ?></strong></td>
                        <td><?php echo $planet_id . " (" . $planet_name . ")"; ?></td>
                        <td><?php echo $row["age"] ?? ''; ?></td>
                        <td><?php echo $row["power"] ?? ''; ?></td>
                        <td><?php echo $row["Weakness"] ?? $row["weakness"] ?? ''; ?></td>
                        <td style="white-space: nowrap;">
                            <a href="index.php?edit=<?php echo $char_id; ?>" class="btn btn-yellow" style="padding:4px 8px; font-size:12px;">Edit</a>
                            <a href="index.php?delete=<?php echo $char_id; ?>" class="btn btn-red" style="padding:4px 8px; font-size:12px;" onclick="return confirm('ยืนยันการลบข้อมูลนี้?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7" style="text-align: center;">ไม่พบข้อมูลตัวละคร</td></tr>
            <?php endif; ?>
        </table>
    </div>

    <script>
        const presetData = {
            "Heatblast": { planet: "1", age: 16, power: "Pyrokinesis, Fire Generation", weakness: "Water, Fire Extinguishers" },
            "XLR8": { planet: "2", age: 16, power: "Super Speed, Quick Reflexes", weakness: "Ice, Frictionless Surfaces" },
            "Diamondhead": { planet: "3", age: 16, power: "Crystallokinesis, Bulletproof", weakness: "Sonic Sound, High Vibration" },
            "Four Arms": { planet: "4", age: 16, power: "Super Strength, Durability", weakness: "Slow Movement" },
            "Cannonbolt": { planet: "5", age: 16, power: "Sphere Transformation, Armor", weakness: "Top-heavy, Limited Vision" },
            "Wildmutt": { planet: "1", age: 16, power: "Enhanced Smell, Agility", weakness: "Inability to Speak, Loud Noises" },
            "Ripjaws": { planet: "6", age: 16, power: "Underwater Breathing, Strong Jaws", weakness: "Dehydration on Land" },
            "Grey Matter": { planet: "7", age: 16, power: "Super Intelligence, Small Size", weakness: "Small Size, Physical Weakness" },
            "Upgrade": { planet: "8", age: 16, power: "Technopathy, Technological Merging", weakness: "Electricity, EMP" },
            "Stinkfly": { planet: "9", age: 16, power: "Flight, Slime Projection", weakness: "Water-logged Wings" },
            "Ghostfreak": { planet: "10", age: 16, power: "Intangibility, Invisibility", weakness: "Sunlight, Energy Attacks" }
        };

        function autoFillData() {
            const select = document.getElementById('alien_select');
            const info = presetData[select.value];
            if (info) {
                document.getElementById('planet_select').value = String(info.planet);
                document.getElementById('age').value = info.age;
                document.getElementById('power').value = info.power;
                document.getElementById('weakness').value = info.weakness;
            }
        }

        <?php if ($edit_row): ?>
            document.getElementById('alien_select').value = "<?php echo $edit_row['alien_Name'] ?? $edit_row['Alien_Name'] ?? ''; ?>";
        <?php endif; ?>
    </script>
</body>
</html>