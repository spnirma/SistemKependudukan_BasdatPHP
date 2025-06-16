<?php
if (!empty($id_propinsi)) {
    ?>
    <select class="form-control" name="<?php echo htmlspecialchars($nama_input_kabupaten) ?>" id="<?php echo htmlspecialchars($nama_input_kabupaten) ?>" onchange="ajax_load_kecamatan_alamat('<?php echo $nama_input_kabupaten ?>', 'div_kecamatan', 'kecamatan')">
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
    echo "<select class='form-control' disabled >";
    echo "<option value=''>-- Pilih Kabupaten --</option>";
    echo "</select>";
}
