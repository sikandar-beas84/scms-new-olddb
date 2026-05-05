<div class="container mt-4">
    <h4>Import Student SQL</h4>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>


    <?php if (session()->has('import_result')): 
        $result = session('import_result');
        ?>
        <div class="alert alert-info">
            <strong>Total:</strong> <?= esc($result['total']) ?><br>
            <strong>Success:</strong> <?= count($result['successIds']) ?><br>
            <strong>Failed:</strong> <?= count($result['failedRows']) ?>
        </div>

        <?php if (!empty($result['successIds'])): ?>
            <div class="alert alert-danger">
                <strong>Successfully Imported Student IDs:</strong><br>
                <ul>
                    <?php foreach ($result['successIds'] as $row): ?>
                        <li>
                            ID <?= esc($row) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($result['failedRows'])): ?>
            <div class="alert alert-danger">
                <strong>Failed IDs:</strong><br>
                <ul>
                    <?php foreach ($result['failedRows'] as $row): ?>
                        <li>
                            ID <?= esc($row['id']) ?> — <?= esc($row['error']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    <?php endif; ?>


    <!-- No Errors -->
    <?php if (empty($result['failedRows'])): ?>
        <div class="alert alert-success">
            🎉 All students imported successfully!
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label">Upload SQL File</label>
            <input type="file" name="sql_file" class="form-control" accept=".sql" required>
        </div>

        <button type="submit" class="btn btn-primary">
            Import Data
        </button>
    </form>

    <hr>

    <p><strong>CSV Format:</strong></p>
    <pre>
        code,class_id,section_id,status,session_year_id
        STU001,10,2,1,2025
        STU002,9,1,1,2025
    </pre>
</div>