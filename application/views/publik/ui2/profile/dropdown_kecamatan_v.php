<?php
if (!empty($id_kecamatan)) {
    if (!empty($kecamatan)) {
        ?>
        <select class="form-control" name="<?php echo htmlspecialchars($nama_input_kecamatan) ?>" id="<?php echo htmlspecialchars($nama_input_kecamatan) ?>">
            <?php
            echo "<option value=''>-- Pilih Kecamatan --</option>";
            if (!empty($kecamatan)) {
                foreach ($kecamatan as $row) {
                    echo "<option value='" . $row->id_kecamatan . "'>" . htmlspecialchars(ucwords($row->nama_kecamatan)) . "</option>";
                }
            }
            ?>
        </select>
        <?php
    } else {
        echo "";
    }
} else {
    echo "<select class='form-control' disabled >";
    echo "<option value=''>-- Pilih Kecamatan --</option>";
    echo "</select>";
}
