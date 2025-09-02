ClassicEditor
  .create(document.querySelector('#editor'), {
    toolbar: ['insertTemplate', '|', 'bold', 'italic', 'undo', 'redo'],
    extraPlugins: [InsertTemplatePlugin]
  })
  .catch(error => {
    console.error(error);
  });

function InsertTemplatePlugin(editor) {
  editor.ui.componentFactory.add('insertTemplate', locale => {
    const view = new editor.ui.componentFactory.constructor.View(locale);

    view.set({
      label: 'Insert Report Template',
      tooltip: true,
      withText: true
    });

    view.on('execute', () => {
      const template = `
<h2>DUTY OFFICER REPORT</h2>
<h3>Details</h3>
<ul>
  <li>Name:</li>
  <li>Dept/Dte:</li>
  <li>Reporting Time:</li>
  <li>Contact Number:</li>
  <li>Period Covered:</li>
</ul>

<h3>General</h3>
<ol>
  <li>Sy Gen:</li>
  <li>Significant Event:</li>
</ol>

<h3>Ops Room</h3>
<ol start="3">
  <li>Comm State.</li>
  <li>Messages/Correspondence Received.</li>
</ol>
<ul>
  <li>b.</li>
  <li>c.</li>
  <li>d.</li>
</ul>
<ol start="5">
  <li>Visit to the Ops Room.</li>
</ol>

<h3>SITREP - Camp</h3>
<ol start="6">
  <li>Sy Gen.</li>
</ol>
<ul>
  <li>a. Main Gate.</li>
  <li>b. Comd Gate.</li>
  <li>c. Congo Junction.</li>
  <li>d. GAFPO.</li>
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
  <li>Duty Vehicle.</li>
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
      editor.setData(template);
    });

    return view;
  });
}
