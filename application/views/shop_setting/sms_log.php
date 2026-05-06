<section class="main-content-wrapper">
    <h3 class="top-left-header">SMS Log Viewer (<?= escape_output($log_date) ?>)</h3>
    <div class="box-wrapper">
        <div class="table-box">
            <div class="box-body">
                <div class="mb-3">
                    <form method="get" action="<?= base_url('Short_message_service/smsLogViewer') ?>">
                        <label>Select Date</label>
                        <input type="date" name="date" class="form-control w-25 d-inline" value="<?= escape_output($log_date) ?>">
                        <button type="submit" class="btn btn-primary ms-2">Load</button>
                    </form>
                </div>
                <?php if (empty($log_lines)) : ?>
                    <div class="alert alert-info">No SMS log entries found for this date.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Timestamp</th>
                                    <th>Message</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($log_lines as $line): 
                                    preg_match('/^(?<stamp>[^ ]+ [^ ]+) --> (?<rest>.+)$/', $line, $m);
                                    $stamp = isset($m['stamp']) ? $m['stamp'] : '';
                                    $rest = isset($m['rest']) ? $m['rest'] : $line;
                                ?>
                                <tr>
                                    <td><?= escape_output($stamp) ?></td>
                                    <td><?= escape_output($rest) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
