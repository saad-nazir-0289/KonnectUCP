$(document).ready(function () {
  // Load tasks on page load
  loadTasks();

  // Create Task
$("#create-task-btn").off("click").on("click", function () {
    let title = $("#task-title").val().trim();
    let description = $("#task-description").val().trim();

    if (title === "" || description === "") {
        alert("Please fill in both fields.");
        return;
    }

    $.post("add_task.php", { title: title, description: description }, function (response) {
        if (response === "success") {
            alert("Task created successfully!");
            $("#task-title, #task-description").val(""); // Corrected line
            loadTasks(); // Reload available tasks
        } else {
            alert(response);
        }
    });
});

  // Load Tasks
  function loadTasks() {
      $.getJSON("fetch_tasks.php", function (data) {
       
          let taskList = $("#task-list");
          taskList.empty();

          data.forEach(task => {
              let taskCard = `
                  <div class="col-md-4">
                      <div class="card task-card" data-username="${task.username}">
                          <div class="card-body">
                              <h5 class="card-title">${task.title}</h5>
                              <p class="card-text">${task.description}</p>
                              <small class="text-muted">Posted by: ${task.username}</small>
                          </div>
                      </div>
                  </div>
              `;
              taskList.append(taskCard);
          });

          $(".task-card").click(function () {
              let owner = $(this).data("username");
              window.location.href = `messages.html?user=${owner}`;
          });
      });
  }
});
