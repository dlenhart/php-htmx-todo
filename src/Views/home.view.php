<?php require "partials/header.view.php"; ?>

<div class="container">
  <div class="container mt-5">
    <h1 class="text-center mb-4">To Do List</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form id="todo-form">
                        <div class="input-group mb-3">
                            <label for="todo-input"></label>
                            <input type="text" class="form-control"
                               id="todo-input"
                               placeholder="Add new task"
                               required
                            >
                            <button hx-post="api/todos" class="btn btn-primary" type="submit">
                                  Add
                              </button>
                        </div>
                    </form>
                      <i> Found <?= $count; ?> tasks.</i>
                      <ul class="list-group" id="todo-list">
                        <?php foreach ($results as $task): ?>
                              <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="task-text"><?= $task['todo']; ?> - <?= $task['description']; ?></span>                                  
                                <input type="text" class="form-control edit-input" style="display:none" value="<?= $task['id']; ?>">
                                <div class="btn-group">
                                  <button class="btn btn-danger btn-sm delete-btn">✕</button>
                                  <button class="btn btn-primary btn-sm edit-btn">✎</button>
                                </div>
                              </li>
                        <?php endforeach; ?>
                    </ul>
                    <br />

                    <?php if ($next): ?> 
                          <button hx-get="<?= $next; ?>"
                              id="load-more"
                              class="btn btn-primary" 
                              hx-swap="afterend" 
                              hx-target="#todo-list" 
                              hx-trigger="click" 
                              hx-disabled-elt="this"
                            >
                            Load More...
                          </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div><!-- end container -->
</div>

<?php require "partials/footer.view.php"; ?>