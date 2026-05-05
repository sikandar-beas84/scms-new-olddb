<?php 
$total = count($students);
$i = 0;
foreach ($students as $student):
    $i++;
    // Only add the break if this is not the last record
    $pageBreak = ($i < $total) ? 'page-break-after: always;' : ''; ?>
<div style="<?= $pageBreak ?> width: 86mm; height: 54mm; margin: 0; padding: 0;">
    
    <div style="background-image: url('<?= FCPATH . 'public/img/scms_old.jpg'; ?>'); 
                background-image-resize: 6; 
                width: 86mm; 
                height: 54mm; 
                position: relative; 
                margin: 0; 
                padding: 0;">
        <div style=" padding-top: 75px"></div>
        
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 60mm; padding-left: 5mm; vertical-align: top;">
                    <table style="width: 100%; font-family: sans-serif; font-size: 7pt;">
                        <tr>
                            <td colspan="3" style="font-size: 10pt; color: red; font-weight: bold; text-align: center; padding-bottom: 2mm;">
                                <?= strtoupper($student['first_name'] ?? '-') ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15mm; font-weight: bold;">ID No</td>
                            <td style="width: 2mm;">:</td>
                            <td style="color: #021678; font-weight: bold;"><?= $student['student_code'] ?? '-' ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Guardian</td>
                            <td>:</td>
                            <td style="color: #010E4A; font-weight: bold;">
                                <?= ((int)($student['mothers_is_gurgent'] ?? 0) == 0) ? ($student['father_name'] ?? '-') : ($student['mother_name'] ?? '-') ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Class</td>
                            <td>:</td>
                            <td style="color: #010E4A; font-weight: bold;">
                                <?= isset($student['class_id']) ? get_class_name_by_id($student['class_id']) : '-' ?>
                            </td>
                        </tr>

                        <?php if(isset($student['class_id']) && $student['class_id'] == 1){?>
                            <tr>
                                <td style="font-weight: bold;">Section</td>
                                <td>:</td>
                                <td style="color: #010E4A; font-weight: bold;">
                                    <?= isset($student['section_id']) ? section_name_by_id($student['section_id']) : '-' ?>
                                </td>
                            </tr>
                        <?php } ?>
                        
                        <tr>
                            <td style="vertical-align: top; font-weight: bold;">Address</td>
                            <td style="vertical-align: top;">:</td>
                            <td style="color: #010E4A; font-size: 7pt; line-height: 1.1;">
                                <?= str_replace(",", ", ", $student['permanent_address'] ?? '-') ?>
                            </td>
                        </tr>
                    </table>
                </td>

                <td style="padding-left: 5mm; width: 26mm; text-align: center; vertical-align: top; padding-top: 2mm;">
                    <?php 
                        $photo = !empty($student['image']) ? FCPATH . 'uploads/' . $student['image'] : FCPATH . 'public/img/noimage.jpg';
                    ?>
                    <img src="<?= $photo ?>" style="width: 18mm; height: 20mm; border: 1px solid #000;">
                </td>
            </tr>
        </table>

        <div style="padding-left: 5mm; position: absolute; bottom: 3mm; left: 5mm; color: red; font-size: 8pt; font-weight: bold;">
            Session : <?= isset($student['session_year_id']) ? session_name_by_id($student['session_year_id']) : '-' ?>
        </div>
        

    </div>
</div>
<?php endforeach; ?>