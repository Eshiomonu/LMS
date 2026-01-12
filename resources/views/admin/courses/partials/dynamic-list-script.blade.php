<script>
function addListItem(button) {
    const wrapper = button.previousElementSibling;
    const input = document.createElement('input');

    input.name = wrapper.querySelector('input').name;
    input.className = 'input mb-2';
    input.placeholder = 'Item';

    wrapper.appendChild(input);
}
</script>
