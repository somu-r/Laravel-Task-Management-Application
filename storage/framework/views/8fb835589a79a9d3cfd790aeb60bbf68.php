<?php $__env->startSection('title', 'TaskFlow - Your Tasks'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <h1 class="page-title animate__animated animate__fadeInDown">
            <i class="bi bi-kanban me-3"></i>Your Task Dashboard
        </h1>

        <!-- Statistics Cards -->
        <div class="row mb-4 animate__animated animate__fadeInUp">
            <?php
                $totalTasks = $tasks->count();
                $completedTasks = $tasks->where('is_completed', true)->count();
                $activeTasks = $tasks->where('is_completed', false)->count();
                $dueTodayTasks = $tasks->where('due_date', today())->count();
                $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
            ?>
            
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stats-number"><?php echo e($totalTasks); ?></div>
                            <div class="text-muted">Total Tasks</div>
                        </div>
                        <i class="bi bi-list-task display-6 text-primary opacity-50"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stats-number text-success"><?php echo e($completedTasks); ?></div>
                            <div class="text-muted">Completed</div>
                        </div>
                        <i class="bi bi-check-circle display-6 text-success opacity-50"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stats-number text-warning"><?php echo e($activeTasks); ?></div>
                            <div class="text-muted">Active</div>
                        </div>
                        <i class="bi bi-clock display-6 text-warning opacity-50"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stats-number text-info"><?php echo e($completionRate); ?>%</div>
                            <div class="text-muted">Progress</div>
                        </div>
                        <div class="progress-ring">
                            <svg class="progress-ring" width="60" height="60">
                                <circle class="progress-ring-circle" 
                                        cx="30" cy="30" r="30" 
                                        style="stroke-dashoffset: <?php echo e(188.5 - (188.5 * $completionRate / 100)); ?>">
                                </circle>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Controls -->
        <div class="filter-controls animate__animated animate__fadeInUp animate__delay-1s">
            <form method="GET" action="<?php echo e(route('tasks.index')); ?>" class="row g-3">
                <div class="col-md-4">
                    <label for="status" class="form-label fw-semibold">
                        <i class="bi bi-funnel me-2"></i>Filter by Status
                    </label>
                    <select name="status" id="status" class="form-select" onchange="this.form.submit()">
                        <option value="all" <?php echo e(request('status') == 'all' ? 'selected' : ''); ?>>
                            <i class="bi bi-list"></i> Show All Tasks
                        </option>
                        <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>
                            <i class="bi bi-circle"></i> Active Only
                        </option>
                        <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>
                            <i class="bi bi-check-circle"></i> Completed Only
                        </option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="due" class="form-label fw-semibold">
                        <i class="bi bi-calendar-event me-2"></i>Filter by Due Date
                    </label>
                    <select name="due" id="due" class="form-select" onchange="this.form.submit()">
                        <option value="" <?php echo e(!request('due') ? 'selected' : ''); ?>>All Dates</option>
                        <option value="today" <?php echo e(request('due') == 'today' ? 'selected' : ''); ?>>
                            <i class="bi bi-calendar-day"></i> Due Today (<?php echo e($dueTodayTasks); ?>)
                        </option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <a href="<?php echo e(route('tasks.index')); ?>" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-clockwise me-2"></i>Clear All Filters
                    </a>
                </div>
            </form>
        </div>

        <!-- Add Task Form -->
        <div class="card mb-4 animate__animated animate__fadeInUp animate__delay-2s">
            <div class="card-header">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-plus-circle-fill me-2"></i>Create New Task
                </h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('tasks.store')); ?>" method="POST" class="row g-3">
                    <?php echo csrf_field(); ?>
                    <div class="col-md-6">
                        <label for="title" class="form-label fw-semibold">
                            <i class="bi bi-pencil me-2"></i>Task Title
                        </label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?php echo e(old('title')); ?>" required 
                               placeholder="What needs to be done?">
                    </div>
                    <div class="col-md-4">
                        <label for="due_date" class="form-label fw-semibold">
                            <i class="bi bi-calendar3 me-2"></i>Due Date
                        </label>
                        <input type="date" class="form-control" id="due_date" name="due_date" 
                               value="<?php echo e(old('due_date')); ?>" min="<?php echo e(today()->format('Y-m-d')); ?>">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-plus-lg me-2"></i>Add Task
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tasks Table -->
        <div class="card animate__animated animate__fadeInUp animate__delay-3s">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-list-check me-2"></i>Your Tasks
                    <span class="badge bg-primary ms-2"><?php echo e($tasks->count()); ?></span>
                </h5>
                <?php if($tasks->count() > 0): ?>
                    <div class="d-flex align-items-center">
                        <span class="text-muted me-3">
                            <?php echo e($completedTasks); ?>/<?php echo e($totalTasks); ?> completed
                        </span>
                        <div class="progress" style="width: 100px; height: 8px;">
                            <div class="progress-bar bg-success" 
                                 style="width: <?php echo e($completionRate); ?>%"></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-body p-0">
                <?php if($tasks->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th width="60" class="text-center">
                                        <i class="bi bi-check2"></i>
                                    </th>
                                    <th>
                                        <i class="bi bi-card-text me-2"></i>Task Title
                                    </th>
                                    <th width="180" class="text-center">
                                        <i class="bi bi-calendar-event me-2"></i>Due Date
                                    </th>
                                    <th width="120" class="text-center">
                                        <i class="bi bi-gear me-2"></i>Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="task-row animate__animated animate__fadeInLeft" 
                                        data-task-id="<?php echo e($task->id); ?>"
                                        style="animation-delay: <?php echo e(($index * 0.1)); ?>s">
                                        <td class="text-center">
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input task-checkbox" 
                                                       type="checkbox" 
                                                       <?php echo e($task->is_completed ? 'checked' : ''); ?>

                                                       data-task-id="<?php echo e($task->id); ?>">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <input type="text" 
                                                       class="task-title-editable <?php echo e($task->is_completed ? 'task-completed' : ''); ?>" 
                                                       value="<?php echo e($task->title); ?>" 
                                                       data-task-id="<?php echo e($task->id); ?>"
                                                       data-original-value="<?php echo e($task->title); ?>">
                                                <?php if($task->is_completed): ?>
                                                    <i class="bi bi-check-circle-fill text-success ms-2"></i>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <?php if($task->due_date): ?>
                                                <?php
                                                    $isOverdue = $task->due_date->isPast() && !$task->is_completed;
                                                    $isDueToday = $task->due_date->isToday();
                                                    $isDueSoon = $task->due_date->isFuture() && $task->due_date->diffInDays() <= 3;
                                                ?>
                                                <span class="badge <?php echo e($isOverdue ? 'bg-danger' : ($isDueToday ? 'bg-warning text-dark' : ($isDueSoon ? 'bg-info' : 'bg-secondary'))); ?>">
                                                    <?php if($isOverdue): ?>
                                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                                    <?php elseif($isDueToday): ?>
                                                        <i class="bi bi-calendar-day me-1"></i>
                                                    <?php else: ?>
                                                        <i class="bi bi-calendar3 me-1"></i>
                                                    <?php endif; ?>
                                                    <?php echo e($task->due_date->format('M d, Y')); ?>

                                                </span>
                                                <?php if($isOverdue): ?>
                                                    <div class="small text-danger mt-1">
                                                        Overdue by <?php echo e($task->due_date->diffForHumans()); ?>

                                                    </div>
                                                <?php elseif($isDueToday): ?>
                                                    <div class="small text-warning mt-1">Due today!</div>
                                                <?php elseif($isDueSoon): ?>
                                                    <div class="small text-info mt-1">
                                                        Due <?php echo e($task->due_date->diffForHumans()); ?>

                                                    </div>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted">
                                                    <i class="bi bi-calendar-x me-1"></i>No due date
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <form action="<?php echo e(route('tasks.destroy', $task)); ?>" method="POST" 
                                                  class="d-inline delete-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                        title="Delete task">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state animate__animated animate__fadeIn">
                        <i class="bi bi-inbox display-1"></i>
                        <h4 class="mt-3 mb-2">No tasks found</h4>
                        <p class="text-muted mb-4">
                            <?php if(request('status') || request('due')): ?>
                                No tasks match your current filters. Try adjusting your search criteria.
                            <?php else: ?>
                                You're all caught up! Add your first task using the form above.
                            <?php endif; ?>
                        </p>
                        <?php if(request('status') || request('due')): ?>
                            <a href="<?php echo e(route('tasks.index')); ?>" class="btn btn-outline-primary">
                                <i class="bi bi-arrow-clockwise me-2"></i>Clear Filters
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Floating Action Button -->
<button class="floating-action" onclick="document.getElementById('title').focus()" title="Add new task">
    <i class="bi bi-plus-lg"></i>
</button>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
$(document).ready(function() {
    // Set up CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Enhanced checkbox toggle with animations
    $('.task-checkbox').change(function() {
        const taskId = $(this).data('task-id');
        const isCompleted = $(this).is(':checked');
        const row = $(this).closest('tr');
        const titleInput = row.find('.task-title-editable');
        const checkbox = $(this);

        // Add loading state
        checkbox.prop('disabled', true);
        row.addClass('animate__animated animate__pulse');

        $.ajax({
            url: `/tasks/${taskId}`,
            method: 'PUT',
            data: {
                title: titleInput.val(),
                is_completed: isCompleted
            },
            success: function(response) {
                if (isCompleted) {
                    titleInput.addClass('task-completed');
                    row.addClass('animate__animated animate__bounceIn');
                    // Add success icon
                    if (!titleInput.siblings('.bi-check-circle-fill').length) {
                        titleInput.parent().append('<i class="bi bi-check-circle-fill text-success ms-2 animate__animated animate__zoomIn"></i>');
                    }
                } else {
                    titleInput.removeClass('task-completed');
                    titleInput.siblings('.bi-check-circle-fill').remove();
                }
                
                // Update progress statistics
                setTimeout(() => {
                    location.reload();
                }, 1000);
            },
            error: function() {
                // Revert checkbox state on error
                checkbox.prop('checked', !isCompleted);
                row.addClass('animate__animated animate__shakeX');
                
                // Show error notification
                showNotification('Error updating task status', 'error');
            },
            complete: function() {
                checkbox.prop('disabled', false);
                row.removeClass('animate__pulse');
            }
        });
    });

    // Enhanced inline editing with better UX
    $('.task-title-editable').on('blur keypress', function(e) {
        if (e.type === 'keypress' && e.which !== 13) {
            return;
        }

        const taskId = $(this).data('task-id');
        const newTitle = $(this).val().trim();
        const originalTitle = $(this).data('original-value');
        const input = $(this);

        if (newTitle === originalTitle || newTitle === '') {
            input.val(originalTitle);
            return;
        }

        const checkbox = input.closest('tr').find('.task-checkbox');
        const isCompleted = checkbox.is(':checked');

        // Add loading state
        input.prop('disabled', true);
        input.addClass('animate__animated animate__pulse');

        $.ajax({
            url: `/tasks/${taskId}`,
            method: 'PUT',
            data: {
                title: newTitle,
                is_completed: isCompleted
            },
            success: function(response) {
                input.data('original-value', newTitle);
                input.addClass('animate__animated animate__flash');
                
                // Show success feedback
                showNotification('Task updated successfully!', 'success');
                
                setTimeout(() => {
                    input.removeClass('animate__flash');
                }, 1000);
            },
            error: function() {
                input.val(originalTitle);
                input.addClass('animate__animated animate__shakeX');
                
                showNotification('Error updating task title', 'error');
                
                setTimeout(() => {
                    input.removeClass('animate__shakeX');
                }, 1000);
            },
            complete: function() {
                input.prop('disabled', false);
                input.removeClass('animate__pulse');
            }
        });
    });

    // Enhanced delete with confirmation and animation
    $('.delete-form').submit(function(e) {
        e.preventDefault();
        
        const form = $(this);
        const row = form.closest('tr');
        const taskTitle = row.find('.task-title-editable').val();

        // Custom confirmation dialog
        if (!confirm(`Are you sure you want to delete "${taskTitle}"?\n\nThis action cannot be undone.`)) {
            return;
        }

        // Add deletion animation
        row.addClass('animate__animated animate__fadeOutRight');

        setTimeout(() => {
            $.ajax({
                url: form.attr('action'),
                method: 'DELETE',
                success: function() {
                    row.remove();
                    
                    // Update task count
                    const count = $('.task-row').length;
                    $('.badge.bg-primary').text(count);
                    
                    showNotification('Task deleted successfully!', 'success');
                    
                    // Show empty state if no tasks left
                    if (count === 0) {
                        setTimeout(() => location.reload(), 500);
                    }
                },
                error: function() {
                    row.removeClass('animate__fadeOutRight');
                    row.addClass('animate__animated animate__shakeX');
                    showNotification('Error deleting task', 'error');
                }
            });
        }, 500);
    });

    // Notification system
    function showNotification(message, type = 'info') {
        const alertClass = type === 'success' ? 'alert-success' : 
                          type === 'error' ? 'alert-danger' : 'alert-info';
        
        const notification = $(`
            <div class="alert ${alertClass} alert-dismissible fade show position-fixed animate__animated animate__slideInRight" 
                 style="top: 100px; right: 20px; z-index: 9999; min-width: 300px;">
                <i class="bi bi-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        
        $('body').append(notification);
        
        // Auto-remove after 3 seconds
        setTimeout(() => {
            notification.addClass('animate__slideOutRight');
            setTimeout(() => notification.remove(), 500);
        }, 3000);
    }

    // Smooth scroll to add task form when floating button is clicked
    $('.floating-action').click(function() {
        $('html, body').animate({
            scrollTop: $('.card').first().offset().top - 100
        }, 500);
    });

    // Add keyboard shortcuts
    $(document).keydown(function(e) {
        // Ctrl/Cmd + N to focus on new task input
        if ((e.ctrlKey || e.metaKey) && e.which === 78) {
            e.preventDefault();
            $('#title').focus();
        }
    });

    // Initialize tooltips
    $('[title]').tooltip();
});
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ubuntu/task-management-app/resources/views/tasks/index.blade.php ENDPATH**/ ?>