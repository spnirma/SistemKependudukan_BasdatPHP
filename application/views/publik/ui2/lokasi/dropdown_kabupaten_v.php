<?php
if (!empty($id_propinsi)) {
    ?>
    <select class="form-control kabupaten<?php echo htmlspecialchars($key) ?>" name="<?php echo htmlspecialchars($nama_input_kabupaten) ?>" id="<?php echo htmlspecialchars($nama_input_kabupaten) ?>" onchange="ajax_load_kecamatan('<?php echo $nama_input_kabupaten ?><?php echo htmlspecialchars($key) ?>', 'kecamatan<?php echo htmlspecialchars($key) ?>', 'id_kecamatan', <?php echo htmlspecialchars($key) ?>)">
        <?php
        echo "<option value=''>-- Pilih Kabupaten --</option>";
        if (!empty($kabupaten)) {
            foreach ($kabupaten as $row) {
                echo "<option value='" . $row->id_kabupaten . "'>" . htmlspecialchars(ucwords(strtolower($row->nama_kabupaten))) . "</option>";
            }
        }
        ?>
    </select>
    <?php
} else {
    ?>
    <select class="form-control kabupaten<?php echo htmlspecialchars($key) ?>" name="<?php echo htmlspecialchars($nama_input_kabupaten) ?>" id="<?php echo htmlspecialchars($nama_input_kabupaten) ?>" onchange="ajax_load_kecamatan('<?php echo $nama_input_kabupaten ?><?php echo htmlspecialchars($key) ?>', 'kecamatan<?php echo htmlspecialchars($key) ?>', 'id_kecamatan', <?php echo htmlspecialchars($key) ?>)" disabled>
        <option value=''>-- Pilih Kabupaten --</option>
    </select>
    <?php
}
?>
