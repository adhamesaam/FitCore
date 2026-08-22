<?php
include_once('../header.php');

if (!isset($_SESSION['id'])) {
  header('Location: login.php');
  exit();
}
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="styles/goalsStyle.css">

<main>

  <!-- Page Header -->
  <section class="goals-hero">
    <div class="container-lg">
      <h1>Your <span class="highlight">Goals</span></h1>
      <p>Manage the daily calorie target we calculated at signup, and add extra goals to stay on track.</p>
    </div>
  </section>

  <!-- Goals Content -->
  <section class="goals-section">
    <div class="container-lg">

      <div class="row mb-5">
        <div class="col-12">
          <div class="target-card d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
              <div class="label">Daily Calorie Target</div>
              <div id="targetDisplayWrap">
                <span class="target-value-display" id="targetValueDisplay">2200</span>
                <span class="unit-label">kcal / day</span>
              </div>
              <div id="targetEditWrap" class="d-none align-items-center">
                <input type="number" class="target-value-input" id="targetValueInput" value="2200" min="0">
                <span class="unit-label">kcal / day</span>
              </div>
            </div>
            <div>
              <button class="btn-secondary-custom" id="editTargetBtn">
                <i class="fas fa-pen me-1"></i> Edit
              </button>
              <button class="btn-primary-custom d-none" id="saveTargetBtn">
                <i class="fas fa-check me-1"></i> Save
              </button>
              <button class="btn-secondary-custom d-none" id="cancelTargetBtn">
                Cancel
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-2">
          <h2 class="section-title">Your <span class="highlight">Goals</span></h2>
          <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addGoalModal">
            <i class="fas fa-plus me-1"></i> Add Goal
          </button>
        </div>
      </div>

      <div class="row g-4" id="goalsGrid">
      </div>

      <div class="empty-state d-none" id="emptyState">
        <i class="fas fa-bullseye fa-2x mb-3" style="color: var(--neon-yellow);"></i>
        <p class="mb-0">No goals yet. Click "Add Goal" to create your first one.</p>
      </div>

    </div>
  </section>

</main>

<div class="modal fade" id="addGoalModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content fitcore-modal">
      <div class="modal-header">
        <h5 class="modal-title" id="goalModalTitle">Add Goal</h5>
        <button type="button" class="btn-close btn-close-custom" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="goalForm">
          <input type="hidden" id="goalId">
          <div class="mb-3">
            <label class="form-label" for="goalName">Goal Name</label>
            <input type="text" class="form-control" id="goalName" placeholder="e.g. Protein Intake" required>
          </div>
          <div class="mb-3">
            <label class="form-label" for="goalType">Goal Type</label>
            <select class="form-select" id="goalType">
              <option value="Calories">Calories</option>
              <option value="Protein">Protein</option>
              <option value="Weight">Weight</option>
              <option value="Water">Water</option>
              <option value="Custom">Custom</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label" for="goalTarget">Target Value</label>
            <input type="number" class="form-control" id="goalTarget" placeholder="e.g. 150" min="0" required>
          </div>
          <div class="mb-3">
            <label class="form-label" for="goalUnit">Unit</label>
            <input type="text" class="form-control" id="goalUnit" placeholder="e.g. g, kcal, kg, L">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn-primary-custom" id="saveGoalBtn">Save Goal</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const STORAGE_KEY = 'fitcore_goals';
  const TARGET_KEY = 'fitcore_daily_target';

  const goalsGrid = document.getElementById('goalsGrid');
  const emptyState = document.getElementById('emptyState');
  const goalModalEl = document.getElementById('addGoalModal');
  const goalModal = new bootstrap.Modal(goalModalEl);
  const goalModalTitle = document.getElementById('goalModalTitle');
  const goalForm = document.getElementById('goalForm');

  function loadGoals() {
    return JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
  }

  function saveGoals(goals) {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(goals));
  }

  function renderGoals() {
    const goals = loadGoals();
    goalsGrid.innerHTML = '';

    if (goals.length === 0) {
      emptyState.classList.remove('d-none');
      return;
    }
    emptyState.classList.add('d-none');

    goals.forEach(goal => {
      const col = document.createElement('div');
      col.className = 'col-md-6 col-lg-4';
      col.innerHTML = `
      <div class="goal-card">
        <span class="goal-type">${goal.type}</span>
        <h4>${goal.name}</h4>
        <div class="goal-value">${goal.target} ${goal.unit || ''}</div>
        <div class="goal-actions">
          <button class="btn-secondary-custom edit-goal-btn" data-id="${goal.id}">
            <i class="fas fa-pen me-1"></i> Edit
          </button>
          <button class="btn-danger-custom delete-goal-btn" data-id="${goal.id}">
            <i class="fas fa-trash me-1"></i> Delete
          </button>
        </div>
      </div>
    `;
      goalsGrid.appendChild(col);
    });

    document.querySelectorAll('.edit-goal-btn').forEach(btn => {
      btn.addEventListener('click', () => openEditModal(btn.dataset.id));
    });
    document.querySelectorAll('.delete-goal-btn').forEach(btn => {
      btn.addEventListener('click', () => deleteGoal(btn.dataset.id));
    });
  }

  function openAddModal() {
    goalModalTitle.textContent = 'Add Goal';
    goalForm.reset();
    document.getElementById('goalId').value = '';
  }

  function openEditModal(id) {
    const goals = loadGoals();
    const goal = goals.find(g => g.id === id);
    if (!goal) return;

    goalModalTitle.textContent = 'Edit Goal';
    document.getElementById('goalId').value = goal.id;
    document.getElementById('goalName').value = goal.name;
    document.getElementById('goalType').value = goal.type;
    document.getElementById('goalTarget').value = goal.target;
    document.getElementById('goalUnit').value = goal.unit || '';
    goalModal.show();
  }

  function deleteGoal(id) {
    if (!confirm('Delete this goal?')) return;
    const goals = loadGoals().filter(g => g.id !== id);
    saveGoals(goals);
    renderGoals();
  }

  document.getElementById('saveGoalBtn').addEventListener('click', () => {
    if (!goalForm.reportValidity()) return;

    const id = document.getElementById('goalId').value;
    const name = document.getElementById('goalName').value.trim();
    const type = document.getElementById('goalType').value;
    const target = document.getElementById('goalTarget').value;
    const unit = document.getElementById('goalUnit').value.trim();

    let goals = loadGoals();

    if (id) {
      goals = goals.map(g => g.id === id ? {
        ...g,
        name,
        type,
        target,
        unit
      } : g);
    } else {
      goals.push({
        id: Date.now().toString(),
        name,
        type,
        target,
        unit
      });
    }

    saveGoals(goals);
    renderGoals();
    goalModal.hide();
  });

  goalModalEl.addEventListener('show.bs.modal', (e) => {
    if (!document.getElementById('goalId').value) {
      // triggered by the "Add Goal" button rather than an edit click
    }
  });

  document.querySelector('[data-bs-target="#addGoalModal"]').addEventListener('click', openAddModal);

  const targetDisplayWrap = document.getElementById('targetDisplayWrap');
  const targetEditWrap = document.getElementById('targetEditWrap');
  const targetValueDisplay = document.getElementById('targetValueDisplay');
  const targetValueInput = document.getElementById('targetValueInput');
  const editTargetBtn = document.getElementById('editTargetBtn');
  const saveTargetBtn = document.getElementById('saveTargetBtn');
  const cancelTargetBtn = document.getElementById('cancelTargetBtn');

  function loadTarget() {
    const stored = localStorage.getItem(TARGET_KEY);
    return stored ? stored : targetValueDisplay.textContent;
  }

  function initTarget() {
    const value = loadTarget();
    targetValueDisplay.textContent = value;
    targetValueInput.value = value;
  }

  function toggleTargetEdit(isEditing) {
    targetDisplayWrap.classList.toggle('d-none', isEditing);
    targetEditWrap.classList.toggle('d-none', !isEditing);
    targetEditWrap.classList.toggle('d-flex', isEditing);
    editTargetBtn.classList.toggle('d-none', isEditing);
    saveTargetBtn.classList.toggle('d-none', !isEditing);
    cancelTargetBtn.classList.toggle('d-none', !isEditing);
  }

  editTargetBtn.addEventListener('click', () => {
    targetValueInput.value = targetValueDisplay.textContent;
    toggleTargetEdit(true);
    targetValueInput.focus();
  });

  cancelTargetBtn.addEventListener('click', () => {
    toggleTargetEdit(false);
  });

  saveTargetBtn.addEventListener('click', () => {
    const newValue = targetValueInput.value;
    if (newValue === '' || Number(newValue) < 0) return;
    targetValueDisplay.textContent = newValue;
    localStorage.setItem(TARGET_KEY, newValue);
    toggleTargetEdit(false);
  });

  initTarget();
  renderGoals();
</script>