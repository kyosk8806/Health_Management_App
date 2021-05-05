$(function() {
    // Delete Modal
    $('#deleteModal').on('shown.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var url = button.data('delete_uri');
        var modal = $(this);
        modal.find('form').attr('action',url);
    });

    // Edit Modal
    $('#editModal').on('shown.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var url = button.data('edit_uri');
        var date = button.data('date');
        var weight = button.data('weight');
        var step = button.data('step');
        var exercise = button.data('exercise');
        var note = button.data('note');
        var modal = $(this);
        modal.find('form').attr('action',url);
        $('#date').val(date);
        $('#weight').val(weight);
        $('#step').val(step);
        $('#exercise').val(exercise);
        $('#note').val(note);
    });

    // Profile Modal
    $('#profileModal').on('shown.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var url = button.data('edit_uri');
        var name = button.data('name');
        var age = button.data('age');
        var height = button.data('height');
        var target_weight = button.data('target_weight');
        var modal = $(this);
        modal.find('form').attr('action',url);
        $('#name').val(name);
        $('#age').val(age);
        $('#height').val(height);
        $('#target_weight').val(target_weight);
    });
})