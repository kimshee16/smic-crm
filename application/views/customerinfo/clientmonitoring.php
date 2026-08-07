<?php
  $this->load->view('layout/header');
  $monitoring_json = json_encode($clients, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
  if ($monitoring_json === false) {
    $monitoring_json = '[]';
  }
?>
<style>
  .client-monitoring-page .monitoring-shell {
    display: grid;
    gap: 16px;
    grid-template-columns: minmax(300px, 34%) minmax(0, 1fr);
    min-height: calc(100vh - 176px);
  }

  .monitoring-panel {
    background: #ffffff;
    border: 1px solid #dbe4ee;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    min-height: 620px;
  }

  .monitoring-panel.client-list-panel {
    height: calc(100vh - 176px);
    min-height: 620px;
    position: sticky;
    top: 12px;
  }

  .monitoring-panel-header {
    align-items: center;
    border-bottom: 1px solid #edf2f7;
    display: flex;
    justify-content: space-between;
    padding: 14px 16px;
  }

  .monitoring-panel-header h2 {
    font-size: 16px;
    font-weight: 800;
    margin: 0;
  }

  .monitoring-search {
    padding: 12px 16px;
  }

  .monitoring-list {
    flex: 1 1 auto;
    min-height: 0;
    overflow-y: auto;
    padding: 0 10px 12px;
  }

  .client-monitor-item {
    background: transparent;
    border: 1px solid transparent;
    border-radius: 8px;
    color: #263746;
    cursor: pointer;
    display: block;
    margin-bottom: 8px;
    padding: 11px 12px;
    text-align: left;
    width: 100%;
  }

  .client-monitor-item:hover,
  .client-monitor-item.active {
    background: #eef7ff;
    border-color: #b7dfff;
  }

  .client-monitor-name {
    font-size: 14px;
    font-weight: 800;
    margin-bottom: 5px;
  }

  .client-monitor-meta {
    color: #607181;
    display: flex;
    flex-wrap: wrap;
    font-size: 12px;
    gap: 7px;
  }

  .critical-pill {
    border-radius: 999px;
    display: inline-flex;
    font-size: 11px;
    font-weight: 800;
    line-height: 1;
    padding: 5px 8px;
    text-transform: uppercase;
  }

  .critical-danger {
    background: #fde8ec;
    color: #b4233c;
  }

  .critical-warning {
    background: #fff4d6;
    color: #8a5a00;
  }

  .critical-info {
    background: #e9f4ff;
    color: #1769aa;
  }

  .critical-success {
    background: #e6f7ee;
    color: #147a43;
  }

  .detail-body {
    padding: 16px;
  }

  .detail-hero {
    align-items: flex-start;
    border-bottom: 1px solid #edf2f7;
    display: flex;
    justify-content: space-between;
    margin-bottom: 16px;
    padding-bottom: 14px;
  }

  .detail-hero h2 {
    font-size: 22px;
    font-weight: 800;
    margin: 0 0 4px;
  }

  .detail-muted {
    color: #607181;
    font-size: 13px;
  }

  .detail-grid {
    display: grid;
    gap: 10px;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    margin-bottom: 16px;
  }

  .detail-metric {
    background: #f8fafc;
    border: 1px solid #e3ebf3;
    border-radius: 8px;
    padding: 10px;
  }

  .detail-metric span {
    color: #607181;
    display: block;
    font-size: 11px;
    font-weight: 800;
    margin-bottom: 4px;
    text-transform: uppercase;
  }

  .detail-metric strong {
    color: #263746;
    font-size: 14px;
  }

  .detail-section {
    margin-top: 18px;
  }

  .detail-section h3 {
    color: #1f2d3d;
    font-size: 15px;
    font-weight: 800;
    margin: 0 0 10px;
  }

  .detail-table-wrap {
    border: 1px solid #dbe4ee;
    border-radius: 8px;
    overflow-x: auto;
  }

  .detail-table {
    margin-bottom: 0;
    min-width: 680px;
  }

  .detail-table th {
    white-space: nowrap;
  }

  .monitoring-value-link {
    color: #007bff;
    font-weight: 700;
    text-decoration: none;
  }

  .monitoring-value-link:hover {
    text-decoration: underline;
  }

  .detail-action {
    white-space: nowrap;
  }

  .detail-action-group {
    display: inline-flex;
    gap: 4px;
    white-space: nowrap;
  }

  .file-list {
    display: grid;
    gap: 8px;
  }

  .file-item {
    align-items: center;
    border: 1px solid #e3ebf3;
    border-radius: 8px;
    display: flex;
    gap: 10px;
    justify-content: space-between;
    padding: 10px 12px;
  }

  .file-item strong {
    display: block;
    font-size: 13px;
  }

  .file-item small {
    color: #607181;
  }

  .empty-state {
    color: #607181;
    padding: 16px;
    text-align: center;
  }

  @media (max-width: 991.98px) {
    .client-monitoring-page .monitoring-shell {
      grid-template-columns: 1fr;
    }

    .monitoring-list {
      max-height: 420px;
    }

    .monitoring-panel.client-list-panel {
      height: auto;
      position: static;
    }

    .detail-grid {
      grid-template-columns: repeat(2, minmax(0, 1fr));
    }
  }

  @media (max-width: 575.98px) {
    .detail-grid {
      grid-template-columns: 1fr;
    }

    .detail-hero {
      display: block;
    }

    .detail-hero .btn {
      margin-top: 10px;
    }
  }
</style>

<div class="content-wrapper client-monitoring-page">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?php echo $title; ?></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/dashboard">Home</a></li>
            <li class="breadcrumb-item active"><?php echo $title; ?></li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
    <div class="monitoring-shell">
      <aside class="monitoring-panel client-list-panel">
        <div class="monitoring-panel-header">
          <h2>Clients</h2>
          <span class="detail-muted" id="clientCount"></span>
        </div>
        <div class="monitoring-search">
          <input type="search" class="form-control" id="clientSearch" placeholder="Search clients">
        </div>
        <div class="monitoring-list" id="clientList"></div>
      </aside>

      <main class="monitoring-panel">
        <div class="monitoring-panel-header">
          <h2>Client Details</h2>
          <span class="detail-muted">Click a client to review</span>
        </div>
        <div class="detail-body" id="clientDetail"></div>
      </main>
    </div>
  </section>
</div>

<?php $this->load->view('layout/footer'); ?>

<aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<script src="<?php echo $asset_url; ?>plugins/jquery/jquery.min.js"></script>
<script src="<?php echo $asset_url; ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $asset_url; ?>dist/js/adminlte.min.js"></script>
<script>
  var monitoringClients = <?php echo $monitoring_json; ?>;
  var selectedClientId = monitoringClients.length ? monitoringClients[0].client_id : null;
  var canDeleteMonitoring = <?php echo in_array($this->session->officer_role, array('regional manager', 'admin', 'manager')) ? 'true' : 'false'; ?>;

  function valueOrEmpty(value) {
    return value === null || value === undefined || value === '' ? '[empty]' : value;
  }

  function textNode(value) {
    return document.createTextNode(valueOrEmpty(value));
  }

  function linkValue(value, url, title) {
    return {
      text: valueOrEmpty(value),
      url: url || '',
      title: title || 'Edit value',
      className: 'monitoring-value-link'
    };
  }

  function actionLink(url, label) {
    return {
      text: label || 'Edit',
      url: url || '',
      title: label || 'Edit',
      className: 'btn btn-outline-primary btn-xs detail-action'
    };
  }

  function actionButton(url, label, className, iconClass, confirmation) {
    var link = document.createElement('a');
    link.href = url || '#';
    link.className = className + ' detail-action';
    link.title = label;
    link.setAttribute('aria-label', label);
    if (confirmation) {
      link.className += ' confirmation';
    }

    var icon = document.createElement('i');
    icon.className = iconClass;
    icon.setAttribute('aria-hidden', 'true');
    link.appendChild(icon);
    return link;
  }

  function actionButtons(editUrl, deleteUrl) {
    var group = document.createElement('span');
    group.className = 'detail-action-group';
    if (editUrl) {
      group.appendChild(actionButton(editUrl, 'Edit', 'btn btn-outline-primary btn-xs', 'fa fa-edit', false));
    }
    if (canDeleteMonitoring && deleteUrl) {
      group.appendChild(actionButton(deleteUrl, 'Delete', 'btn btn-outline-danger btn-xs', 'fa fa-trash', true));
    }
    if (!group.childNodes.length) {
      group.appendChild(textNode(''));
    }
    return group;
  }

  function appendCellValue(cell, value) {
    if (value && value.nodeType) {
      cell.appendChild(value);
      return;
    }

    if (value && typeof value === 'object') {
      if (value.url) {
        var link = document.createElement('a');
        link.href = value.url;
        link.className = value.className || '';
        link.title = value.title || '';
        if (value.target) {
          link.target = value.target;
        }
        link.appendChild(textNode(value.text));
        cell.appendChild(link);
        return;
      }

      cell.appendChild(textNode(value.text));
      return;
    }

    cell.appendChild(textNode(value));
  }

  function formatDate(value) {
    if (!value || value === '0000-00-00' || value === '1900-01-01') {
      return '[empty]';
    }
    var date = new Date(value);
    if (isNaN(date.getTime())) {
      return value;
    }
    return date.toLocaleDateString('en-AU');
  }

  function criticalClass(client) {
    if (client.critical_score >= 100) return 'critical-danger';
    if (client.critical_score >= 50) return 'critical-warning';
    if (client.critical_score > 0) return 'critical-info';
    return 'critical-success';
  }

  function criticalLabel(client) {
    if (client.critical_score >= 100) return 'Critical';
    if (client.critical_score >= 50) return 'Watch';
    if (client.critical_score > 0) return 'Review';
    return 'Stable';
  }

  function makePill(label, type) {
    var span = document.createElement('span');
    span.className = 'critical-pill critical-' + (type || 'info');
    span.textContent = label;
    return span;
  }

  function renderClientList() {
    var search = document.getElementById('clientSearch').value.toLowerCase();
    var list = document.getElementById('clientList');
    list.innerHTML = '';

    var filtered = monitoringClients.filter(function(client) {
      return !search || client.name.toLowerCase().indexOf(search) !== -1;
    });

    document.getElementById('clientCount').textContent = filtered.length + ' shown';

    if (!filtered.length) {
      var empty = document.createElement('div');
      empty.className = 'empty-state';
      empty.textContent = 'No clients found.';
      list.appendChild(empty);
      return;
    }

    filtered.forEach(function(client) {
      var button = document.createElement('button');
      button.type = 'button';
      button.className = 'client-monitor-item' + (client.client_id === selectedClientId ? ' active' : '');
      button.onclick = function() {
        selectedClientId = client.client_id;
        renderClientList();
        renderClientDetail(client);
      };

      var name = document.createElement('div');
      name.className = 'client-monitor-name';
      name.textContent = client.name || 'Unnamed client';

      var meta = document.createElement('div');
      meta.className = 'client-monitor-meta';
      var pill = makePill(criticalLabel(client), criticalClass(client).replace('critical-', ''));
      meta.appendChild(pill);
      var score = document.createElement('span');
      score.textContent = 'Score ' + client.critical_score;
      meta.appendChild(score);

      var reason = document.createElement('div');
      reason.className = 'detail-muted mt-1';
      reason.textContent = client.critical_reasons.length ? client.critical_reasons[0].label : 'No critical item detected';

      button.appendChild(name);
      button.appendChild(meta);
      button.appendChild(reason);
      list.appendChild(button);
    });
  }

  function metric(label, value) {
    var box = document.createElement('div');
    box.className = 'detail-metric';
    var labelNode = document.createElement('span');
    labelNode.textContent = label;
    var valueNode = document.createElement('strong');
    valueNode.appendChild(textNode(value));
    box.appendChild(labelNode);
    box.appendChild(valueNode);
    return box;
  }

  function tableSection(title, columns, rows, mapper) {
    var section = document.createElement('section');
    section.className = 'detail-section';
    var heading = document.createElement('h3');
    heading.textContent = title;
    section.appendChild(heading);

    if (!rows || !rows.length) {
      var empty = document.createElement('div');
      empty.className = 'empty-state detail-table-wrap';
      empty.textContent = 'No records found.';
      section.appendChild(empty);
      return section;
    }

    var wrap = document.createElement('div');
    wrap.className = 'detail-table-wrap';
    var table = document.createElement('table');
    table.className = 'table table-bordered table-striped detail-table';
    var thead = document.createElement('thead');
    var headRow = document.createElement('tr');
    columns.forEach(function(column) {
      var th = document.createElement('th');
      th.textContent = column;
      headRow.appendChild(th);
    });
    thead.appendChild(headRow);
    table.appendChild(thead);

    var tbody = document.createElement('tbody');
    rows.forEach(function(row) {
      var tr = document.createElement('tr');
      mapper(row).forEach(function(value) {
        var td = document.createElement('td');
        appendCellValue(td, value);
        tr.appendChild(td);
      });
      tbody.appendChild(tr);
    });
    table.appendChild(tbody);
    wrap.appendChild(table);
    section.appendChild(wrap);
    return section;
  }

  function renderFiles(files) {
    var section = document.createElement('section');
    section.className = 'detail-section';
    var heading = document.createElement('h3');
    heading.textContent = 'Google Drive Files';
    section.appendChild(heading);

    if (!files || !files.length) {
      var empty = document.createElement('div');
      empty.className = 'empty-state detail-table-wrap';
      empty.textContent = 'No Google Drive files found.';
      section.appendChild(empty);
      return section;
    }

    var list = document.createElement('div');
    list.className = 'file-list';
    files.forEach(function(file) {
      var item = document.createElement('div');
      item.className = 'file-item';
      var copy = document.createElement('div');
      var title = document.createElement('strong');
      title.textContent = valueOrEmpty(file.type || file.remarks || 'File');
      var meta = document.createElement('small');
      meta.textContent = valueOrEmpty(file.source) + ' | ' + formatDate(file.date) + (file.remarks ? ' | ' + file.remarks : '');
      copy.appendChild(title);
      copy.appendChild(meta);
      item.appendChild(copy);

      if (file.link) {
        var link = document.createElement('a');
        link.href = file.link;
        link.target = '_blank';
        link.className = 'btn btn-outline-primary btn-sm';
        link.textContent = 'Open';
        item.appendChild(link);
      }
      list.appendChild(item);
    });
    section.appendChild(list);
    return section;
  }

  function renderClientDetail(client) {
    var detail = document.getElementById('clientDetail');
    detail.innerHTML = '';

    var hero = document.createElement('div');
    hero.className = 'detail-hero';
    var titleWrap = document.createElement('div');
    var title = document.createElement('h2');
    title.textContent = client.name || 'Unnamed client';
    var subtitle = document.createElement('div');
    subtitle.className = 'detail-muted';
    subtitle.textContent = 'Officer: ' + valueOrEmpty(client.officer) + ' | Email: ' + valueOrEmpty(client.email) + ' | Phone: ' + valueOrEmpty(client.phone);
    titleWrap.appendChild(title);
    titleWrap.appendChild(subtitle);
    hero.appendChild(titleWrap);

    var open = document.createElement('a');
    open.href = client.edit_url;
    open.className = 'btn btn-primary';
    open.textContent = 'Open Client Info';
    hero.appendChild(open);
    detail.appendChild(hero);

    var reasons = document.createElement('div');
    reasons.className = 'mb-3';
    client.critical_reasons.forEach(function(reason) {
      var pill = makePill(reason.label, reason.type);
      pill.className += ' mr-1 mb-1';
      reasons.appendChild(pill);
    });
    detail.appendChild(reasons);

    var grid = document.createElement('div');
    grid.className = 'detail-grid';
    grid.appendChild(metric('PO Process', client.summary.po_process));
    grid.appendChild(metric('Follow-up', formatDate(client.summary.followup)));
    grid.appendChild(metric('Admission', client.summary.admission_status));
    grid.appendChild(metric('VEVO Expiry', formatDate(client.summary.vevo_expiry)));
    grid.appendChild(metric('Visa Status', client.summary.visa_status));
    grid.appendChild(metric('Visa Expiry', formatDate(client.summary.visa_expiry)));
    grid.appendChild(metric('Date Payment', formatDate(client.summary.date_payment)));
    grid.appendChild(metric('Drive Files', client.files.length));
    detail.appendChild(grid);

    detail.appendChild(tableSection('Admission', ['Date', 'Status', 'VEVO Expiry', 'Intake', 'School', 'Program', 'Action'], client.admissions, function(row) {
      return [formatDate(row.date), row.status, formatDate(row.vevo_expiry), row.intake, row.provider, row.course, actionButtons(row.edit_url, row.delete_url)];
    }));

    detail.appendChild(tableSection('Visa Applications', ['Status', 'Submitted', 'Result Release', 'Intake', 'Expiry', 'Action'], client.visa_applications, function(row) {
      return [row.status, formatDate(row.submission_date), formatDate(row.result_release), formatDate(row.intake), formatDate(row.expiry), actionButtons(row.edit_url, row.delete_url)];
    }));

    detail.appendChild(tableSection('Payments', ['Type', 'Reference', 'Description', 'Amount', 'Date', 'Processed By', 'Action'], client.payments, function(row) {
      return [row.type, row.reference, row.description, row.amount, formatDate(row.date), row.processed_by, actionButtons('', row.delete_url)];
    }));

    var feeRows = [
      { label: 'Tuition Fee', amount: client.fees.tuition, url: client.fee_edit_urls.tuition || client.fee_add_url },
      { label: 'Visa Application', amount: client.fees.visa_application, url: client.fee_edit_urls.visa_application || client.fee_add_url },
      { label: 'OSHC', amount: client.fees.oshc, url: client.fee_edit_urls.oshc || client.fee_add_url },
      { label: 'Admin Fee', amount: client.fees.admin, url: client.fee_edit_urls.admin || client.fee_add_url },
      { label: 'Refusal Fee', amount: client.fees.refusal, url: client.fee_edit_urls.refusal || client.fee_add_url },
      { label: 'Processing Fee', amount: client.fees.processing, url: client.fee_edit_urls.processing || client.fee_add_url }
    ];
    detail.appendChild(tableSection('Notice of Payment Summary', ['Fee', 'Amount'], feeRows, function(row) {
      return [row.label, linkValue(row.amount, row.url, 'Edit ' + row.label)];
    }));

    detail.appendChild(tableSection('Fee Receipts', ['Description', 'Amount', 'Date', 'Receipt', 'Action'], client.fee_receipts, function(row) {
      return [
        linkValue(row.description, row.edit_url, 'Edit fee receipt'),
        linkValue(row.amount, row.edit_url, 'Edit fee amount'),
        formatDate(row.date),
        row.receipt_url ? { text: row.receipt, url: row.receipt_url, target: '_blank', title: 'Open receipt', className: 'monitoring-value-link' } : row.receipt,
        actionButtons(row.edit_url, row.delete_url)
      ];
    }));

    detail.appendChild(renderFiles(client.files));
  }

  function markasread() {
    var baseurl10 = document.getElementById('baseurl').value;
    $.ajax({
      type: 'GET',
      url: baseurl10 + 'index.php/markasread',
      success: function() {
        var notif = document.getElementById('notifnum');
        if (notif) {
          notif.remove();
        }
      }
    });
  }

  document.getElementById('clientSearch').addEventListener('input', renderClientList);
  document.addEventListener('click', function(event) {
    var trigger = event.target.closest ? event.target.closest('.confirmation') : null;
    if (trigger && !confirm('Are you sure to delete the entry?')) {
      event.preventDefault();
    }
  });
  renderClientList();
  if (monitoringClients.length) {
    renderClientDetail(monitoringClients[0]);
  } else {
    document.getElementById('clientDetail').innerHTML = '<div class="empty-state">No active clients found.</div>';
  }
</script>
</body>
</html>
