document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('todo-form');
    const taskInput = document.getElementById('new-task');
    const taskList = document.getElementById('todo-list');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        addTask(taskInput.value);
        taskInput.value = '';
    });

    taskList.addEventListener('click', function(e) {
        if (e.target.classList.contains('delete')) {
            removeTask(e.target.parentElement);
        }
    });

    function addTask(task) {
        const li = document.createElement('li');
        li.textContent = task;
        
        const deleteBtn = document.createElement('button');
        deleteBtn.textContent = 'Eliminar';
        deleteBtn.classList.add('delete');
        li.appendChild(deleteBtn);

        taskList.appendChild(li);
    }

    function removeTask(taskItem) {
        taskList.removeChild(taskItem);
    }
});
