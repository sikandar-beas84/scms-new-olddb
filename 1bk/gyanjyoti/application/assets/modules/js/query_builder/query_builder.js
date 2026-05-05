$(document).ready(function() {
    servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list');
    
    //Submit the modal form
    $("#modalFormAdd").on('submit', (function (e) {
        e.preventDefault();
        ajaxFromSubmit(pageURL+'save', this, function (data) {
            closeModal(modalId); // calling function to close Modal
            successMsg(data.message);
            servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list');
        });
    }));

    
});

function openModal(id = 0, type = 0){
    ajaxPostRequest(pageURL+'load_modal',{'id': id}, function(data) {
        $('#'+modalId+'_body').html(data.html);
        $('#'+modalId+'_title').text('Add Query Builder');
        $(".save-btn").hide();
        holdModal(modalId);

        if(type == 1){
            $("#"+modalId+"_body .form-control").attr('disabled', 'disabled');
            $(".save-btn").hide();
            $("#"+modalId+"_title").text('View Query Builder');
        } else if(type == 2){
            $("#"+modalId+"_title").text('Edit Query Builder');
        }
    });
}

function selectOperation(operationId = 0, id = 0, type = 0){
    ajaxPostRequest(pageURL+'select_operation', {'operation_id': operationId, 'id': id}, function (data) {
        
        $('#'+modalId+'_body').html(data.html);
        $('#'+modalId+'_title').text('Add Query Builder');
        $("#"+modalId+"_body .form-control").keyup(function(){
            $( this ).val($( this ).val().replace(/\s/g, ''));
        });
        $(".save-btn").show();

        if(type != 0){      //Added by Suhrid Sarkar || suhrid.developer@gmail.com BAAK on July 10, 2023
            holdModal(modalId);
        }

        if(type == 1){
            $("#"+modalId+"_body .form-control, #"+modalId+"_body .form-check-input, #"+modalId+"_body .btn").attr('disabled', 'disabled');
            $(".save-btn").hide();
            $("#"+modalId+"_title").text('View Query Builder');
        } else if(type == 2){
            $("#"+modalId+"_title").text('Edit Query Builder');
        }
    });
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on July 07, 2023
//For add Create table fields
function addTableField(){
    var count = $('.createTableBody').length;
    ajaxPostRequest(pageURL+'add_table_field', {'count': count, 'operation': 'create_table'}, function (data) {
        $('#createTable tbody').append(data.html);
        $("#"+modalId+"_body .form-control").keyup(function(){
            $( this ).val($( this ).val().replace(/\s/g, ''));
        });
    });
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on July 10, 2023
//For add where table
function addWhereTableField(){
    var count = $('.whereTableBody').length;
    ajaxPostRequest(pageURL+'add_table_field', {'count': count, 'operation': 'select'}, function (data) {
        $('#whereTable tbody').append(data.html);
        $("#"+modalId+"_body .form-control").keyup(function(){
            if(!$(this).hasClass('where_field_value')){
                $( this ).val($( this ).val().replace(/\s/g, ''));
            }
            
        });
    });
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on July 07, 2023
//For change the is null check box value
function changeIsNullValue(count = 0){
    if($('#is_null_'+count).prop('checked')){
        $('#is_null_'+count).val('Y');
        $('#is_null_hdn_'+count).val('Y');      //Added by Suhrid Sarkar || suhrid.developer@gmail.com on July 11, 2023
    }else{
        $('#is_null_'+count).val('N');
        $('#is_null_hdn_'+count).val('N');      //Added by Suhrid Sarkar || suhrid.developer@gmail.com on July 11, 2023
    }
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on July 19, 2023
//For change the is show check box value
function changeIsShowValue(count = 0){
    if($('#is_show_'+count).prop('checked')){
        $('#is_show_'+count).val('Y');
        $('#is_show_hdn_'+count).val('Y');
    }else{
        $('#is_show_'+count).val('N');
        $('#is_show_hdn_'+count).val('N');
    }
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on July 11, 2023
//For execute the query
function executeQuery(queryId = 0){
    if(queryId != 0){
        ajaxPostRequest(pageURL + 'execute_query', {'query_id': queryId}, function (data) {
            successMsg(data.message); // Success Message
        });
    } else{
        warnMsg('Should enter the query id');
    }
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com BAAK on July 19, 2023
//For displaying the tabe details data
function tableModal(queryId = 0){
    var tableName, queryId;
    if(queryId != 0){
        ajaxPostRequest(pageURL + 'open_table_modal', {'query_id': queryId}, function (data) {
            $('#'+tableModalId+'_body').html(data.html);
            $('#'+tableModalId+'_title').text(data.table_name);
            $(".save-btn").hide();
            holdModal(tableModalId);
            tableName = data.table_name;
            queryId = data.query_id;
            servSideDataTable(data.table_name, 10, baseUrl + pageURL + 'query_builder_datatable/'+data.query_id+'/'+data.table_name); //Refresh Datatable
        });
    }else{
        warnMsg('Should enter the query id');
    }
}

//Added by Suhrid Sarkar || suhrid.developer@gmail.com on July 20, 2023
//For Open data modal
function openTableAddDataModal(id = 0, type = 0, columns, datatype, queryId, tableName = ''){
    columns = columns.split(',');
    datatype = datatype.split(',');
    // console.log(columns);
    ajaxPostRequest(
        pageURL+'table_add_data_load_modal',
        {
            'id': id, 
            'columns': columns, 
            'datatype': datatype,
            'query_id': queryId,
            'table_name': tableName
        }, 
        function(data) {

            $('#'+tableAddDataModal+'_body').html(data.html);
            $('#'+tableAddDataModal+'_title').text('Add ');
            $(".save-btn").show();
            holdModal(tableAddDataModal);

            if(type == 1){
                $("#"+tableAddDataModal+"_body .form-control").attr('disabled', 'disabled');
                $(".save-btn").hide();
                $("#"+tableAddDataModal+"_title").text('View ');
            } else if(type == 2){
                $("#"+tableAddDataModal+"_title").text('Edit ');
            }
        }
    );
}

function deleteField(id = ''){
    warningMsg('Are You Sure', 'You won\'t be able to revert this!', 'warning', 'Delete it', function () {
        ajaxPostRequest(pageURL+'delete', {
            "id": id
        }, function (data) {
            successMsg(data.message); // Success Message
            servSideDataTable(tableName, 10, baseUrl + pageURL + 'data_list'); //Refresh Datatable
        });
    });       
}