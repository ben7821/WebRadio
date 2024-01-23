$(document).ready(function() {
    $('#tableEmission').DataTable({
        paging: true,
        pageLength: 5,
        bInfo: false,
        pagingType: 'numbers',
        bLengthChange: false,
    });

    $('#tableAudio').DataTable({
        paging: true,
        pageLength: 5,
        bInfo: false,
        pagingType: 'numbers',
        bLengthChange: false,
    });

    $('#tableMembre').DataTable({
        paging: true,
        pageLength: 5,
        bInfo: false,
        pagingType: 'numbers',
        bLengthChange: false,
    });
});