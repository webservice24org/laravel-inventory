<div class="container-fluid">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="card px-5 py-5">
            <div class="row justify-content-between ">
                <div class="align-items-center col">
                    <h4>Category</h4>
                </div>
                <div class="align-items-center col">
                    <button data-bs-toggle="modal" data-bs-target="#create-modal" class="float-end btn m-0 bg-gradient-primary">Create</button>
                </div>
            </div>
            <hr class="bg-secondary"/>
            <div class="table-responsive">
            <table class="table" id="tableData">
                <thead>
                <tr class="bg-light">
                    <th>No</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="tableList">

                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function () {
    getlist();
    async function getlist() {
    try {
        showLoader();
        let res = await axios.get('/category-list', HeaderToken());
        hideLoader();

        let tableList = $("#tableList");
        let tableData = $("#tableData");

        tableData.DataTable().destroy(); // Use DataTable() instead of dataTable()

        tableList.empty();
        res.data['rows'].forEach(function (item, indes) {
            let row = `<tr>
                <td>${indes + 1}</td>
                <td>${item['name']}</td>
                <td>
                    <button data-id="" class="btn editBtn btn-sm btn-outline-success">Edit</button>
                    <button data-id="" class="btn deleteBtn btn-sm btn-outline-danger">Delete</button>
                </td>
            </tr>`;
            tableList.append(row);
        });

        new DataTable('#tableData', {
            order: [[0, 'desc']],
            lengthMenu: [5, 10, 15, 20, 30]
        });

        //console.log('getlist() executed successfully');
    } catch (e) {
        if (e.response && e.response.status) {
            unauthorized(e.response.status);
        } else {
            console.error('Error:', e);
            // Handle other errors as needed
        }
    }
}

});

</script>