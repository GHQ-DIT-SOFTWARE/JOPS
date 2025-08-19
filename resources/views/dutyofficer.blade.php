<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Duty Officer Report Editor (Summernote)</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Summernote CSS -->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

  <style>
    .note-editor {
      margin-top: 20px;
    }
    body {
      padding: 20px;
    }
  </style>
</head>
<body>

  <h2>Duty Officer Report Editor</h2>
  <button class="btn btn-primary mb-3" onclick="insertTemplate()">Insert Report Template</button>
  <textarea id="summernote"></textarea>

  <!-- Bootstrap + jQuery + Summernote JS -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

  <script>
    $(document).ready(function () {
      $('#summernote').summernote({
        height: 800,
        placeholder: 'Start typing your report here...',
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'italic', 'underline', 'clear']],
          ['fontsize', ['fontsize']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['insert', ['link', 'table']],
          ['view', ['undo', 'redo', 'codeview']]
        ]
      });
    });

    function insertTemplate() {
      const template = `
<h2>DUTY OFFICER REPORT</h2>
<h3>Details</h3>
<ul>
  <li><strong>Name:</strong></li>
  <li><strong>Dept/Dte:</strong></li>
  <li><strong>Reporting Time:</strong></li>
  <li><strong>Contact Number:</strong></li>
  <li><strong>Period Covered:</strong></li>
</ul>

<h3>General</h3>
<ol>
  <li><strong>Sy Gen:</strong></li>
  <li><strong>Significant Event:</strong></li>
</ol>

<h3>Ops Room</h3>
<ol start="3">
  <li><strong>Comm State.</strong></li>
  <li><strong>Messages/Correspondence Received.</strong></li>
</ol>
<ul>
  <li>b.</li>
  <li>c.</li>
  <li>d.</li>
</ul>
<ol start="5">
  <li><strong>Visit to the Ops Room.</strong></li>
</ol>

<h3>SITREP - Camp</h3>
<ol start="6">
  <li><strong>Sy Gen.</strong></li>
</ol>
<ul>
  <li>a. Main Gate</li>
  <li>b. Comd Gate</li>
  <li>c. Congo Junction</li>
  <li>d. GAFTO</li>
</ul>

<h3>Major Event</h3>
<h4>SITREP - Army</h4>
<ol start="7">
  <li>Sy Gen.</li>
  <li>Significant Event.</li>
</ol>

<h4>SITREP - Navy</h4>
<ol start="9">
  <li>Sy Gen.</li>
  <li>Significant Event.</li>
</ol>

<h4>SITREP - Airforce</h4>
<ol start="11">
  <li>Sy Gen.</li>
  <li>Significant Event.</li>
</ol>

<h3>Misc</h3>
<ol start="13">
  <li>Duty Veh.</li>
  <li>Major News of Military Importance Reported in the Print/Electronic Media.</li>
  <li>Admin Gen.</li>
</ol>
<ul>
  <li>a. Lighting *</li>
  <li>b. Feeding</li>
  <li>c. Welfare</li>
</ul>
<ol start="16">
  <li>GHQ Office Keys (Sy).</li>
  <li>GAF Fire Station.</li>
</ol>
<ul>
  <li>a.</li>
  <li>b.</li>
  <li>c.</li>
  <li>d.</li>
  <li>e.</li>
  <li>f.</li>
</ul>

<ol start="19">
  <li>Ops Room Photocopier.</li>
</ol>
<ul>
  <li>a.</li>
</ul>

<h3>Taking Over -</h3>
<h3>Handing Over -</h3>
<h3>Additional Information</h3>
      `;
      $('#summernote').summernote('code', template);
    }
  </script>
</body>
</html>
