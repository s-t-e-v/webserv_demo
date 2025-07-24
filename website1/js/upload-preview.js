// upload-preview.js
// Handles file selection preview, drag/drop, and remove/clear

document.addEventListener('DOMContentLoaded', () => {
  const fileInput    = document.getElementById('fileInput');
  const submitBtn    = document.getElementById('submitBtn');
  const filesPreview = document.getElementById('filesPreview');
  const filesList    = document.getElementById('filesList');
  const summary      = document.getElementById('summary');
  const uploadZone   = document.getElementById('uploadZone');
  const uploadIcon   = document.getElementById('uploadIcon');
  const uploadTitle  = document.getElementById('uploadTitle');
  const uploadSubtitle = document.getElementById('uploadSubtitle');
  const fileCounter  = document.getElementById('fileCounter');
  let selectedFiles = [];

  const escapeHtml = txt => { const d = document.createElement('div'); d.textContent = txt; return d.innerHTML; };
  const fmtSize = b => {
    if (b === 0) return '0 Bytes';
    const k=1024, s=['Bytes','KB','MB','GB'], i=Math.floor(Math.log(b)/Math.log(k));
    return (b/Math.pow(k,i)).toFixed(2)+' '+s[i];
  };
  const iconFor = (t,n) => {
    if(t.startsWith('image/')) return '🖼️';
    if(t.startsWith('video/')) return '🎥';
    if(t.startsWith('audio/')) return '🎵';
    if(t.includes('pdf')) return '📄'; if(t.includes('zip')) return '📦';
    if(n.endsWith('.js')) return '🟨'; if(n.endsWith('.css')) return '🎨';
    if(n.endsWith('.html')) return '🌐'; if(n.endsWith('.doc')) return '📘';
    if(n.endsWith('.xls')) return '📗'; if(n.endsWith('.ppt')) return '📙'; return '📄';
  };

  window.removeFile = i => { selectedFiles.splice(i,1); render(); };
  window.clearAllFiles = () => { selectedFiles=[]; render(); };

  function render() {
    const dt = new DataTransfer();
    selectedFiles.forEach(f=>dt.items.add(f));
    fileInput.files = dt.files;

    if (!selectedFiles.length) {
      filesPreview.style.display='none';
      submitBtn.disabled=true;
      submitBtn.textContent='Select files to upload';
      uploadIcon.textContent='📁';
      uploadTitle.textContent='Choose files or drag them here';
      uploadSubtitle.textContent='You can select multiple files at once';
      fileCounter.textContent='0';
      return;
    }

    filesPreview.style.display='block';
    fileCounter.textContent=selectedFiles.length;
    uploadIcon.textContent='✅';
    uploadTitle.textContent=`${selectedFiles.length} file(s) selected`;
    uploadSubtitle.textContent='Ready to upload';

    let total=0, html='';
    selectedFiles.forEach((f,i)=>{
      total+=f.size;
      html+=`<div class="file-item">
        <span class="file-icon">${iconFor(f.type,f.name)}</span>
        <div class="file-details">
          <h4>${escapeHtml(f.name)}</h4>
          <div class="file-meta">${fmtSize(f.size)} • ${f.type||'Unknown'}</div>
        </div>
        <button class="remove-file" onclick="removeFile(${i})">🗑️ Remove</button>
      </div>`;
    });
    filesList.innerHTML = html;
    summary.innerHTML = `
      <div class="upload-summary-info">
        <div><strong>${selectedFiles.length}</strong><div>Files</div></div>
        <div><strong>${fmtSize(total)}</strong><div>Total Size</div></div>
      </div>
      <div class="upload-summary-note">Ready to upload • add or remove files</div>
    `;

    submitBtn.disabled=false;
    submitBtn.textContent=`📤 Upload ${selectedFiles.length} File(s)`;
  }

  fileInput.addEventListener('change', e=>{
    selectedFiles = Array.from(e.target.files);
    render();
  });

  ['dragover','dragleave','drop'].forEach(evt=>{
    uploadZone.addEventListener(evt,e=>{
      e.preventDefault();
      uploadZone.classList.toggle('dragover', evt==='dragover');
      if(evt==='drop'){
        selectedFiles = selectedFiles.concat(Array.from(e.dataTransfer.files));
        render();
      }
    });
  });

  document.getElementById('uploadForm').addEventListener('submit', e=>{
    if (!selectedFiles.length) { e.preventDefault(); alert('Select at least one file'); }
  });

  render();
});