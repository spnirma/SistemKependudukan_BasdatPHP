<?php
if (!empty($id_kecamatan)) {
    if (!empty($kecamatan)) {
        ?>
        <select class="form-control kecamatan<?php echo htmlspecialchars($key) ?>" name="<?php echo htmlspecialchars($nama_input_kecamatan) ?>" id="<?php echo htmlspecialchars($nama_input_kecamatan) ?>">
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
        ?>
        <select class="form-control kecamatan<?php echo htmlspecialchars($key) ?>" name="<?php echo htmlspecialchars($nama_input_kecamatan) ?>" id="<?php echo htmlspecialchars($nama_input_kecamatan) ?>" disabled>
           <option value=''>-- Tidak ada kecamatan --</option>
        </select>
        <?php
    }
} else {
    ?>
    <select class="form-control kecamatan<?php echo htmlspecialchars($key) ?>" name="<?php echo htmlspecialchars($nama_input_kecamatan) ?>" id="<?php echo htmlspecialchars($nama_input_kecamatan) ?>" disabled>
        <option value=''>-- Tidak ada kecamatan --</option>
    </select>
    <?php
}
?>
