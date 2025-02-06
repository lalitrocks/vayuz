<table id="data-table"
    data-toggle="table"
    data-url="<?= base_url('table/users') ?>"
    data-pagination="true"
    data-search="true"
    data-buttons="buttons">
    <thead>
        <tr>
            <th data-field="id"> ID</th>
            <th data-field="username"> Username</th>
            <th data-field="last_log_in">Last Logged In</th>
            <th data-field="action"> Action</th>

        </tr>
    </thead>
</table>

<script>
    restrictedContent()

    function buttons() {
        return {
            btnExport: {
                text: 'Add',
                icon: 'fa-add',
                event: function() {
                    window.location.href = `<?= base_url('admin/user_add') ?>`
                },
                attributes: {
                    title: 'Add',
                    class: 'btn btn-secondary'
                }
            }
        };
    }
</script>