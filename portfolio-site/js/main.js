// Project data
const projects = [
  {
    name: 'Astonish',
    description: 'A full-featured e-commerce and admin dashboard built with PHP and MySQL. Includes user management, product management, and order tracking.',
    tech: ['PHP', 'MySQL', 'Bootstrap', 'HTML', 'CSS', 'JavaScript'],
    link: 'projects/astonish/index.php',
    linkLabel: 'View Project',
  },
  {
    name: 'Project Othmane Fakir-107',
    description: 'A modern, responsive website using HTML, CSS, JavaScript, and Bootstrap. Features multiple pages, creative layouts, and interactive elements.',
    tech: ['HTML', 'CSS', 'JavaScript', 'Bootstrap'],
    link: 'projects/Project Othmane Fakir-107/acceuil.html',
    linkLabel: 'View Project',
  },
  {
    name: 'Jumpy',
    description: 'A Python-based game demonstrating OOP principles, with custom sprites and engaging gameplay. <br><strong>To play:</strong> Download and unzip, then run <code>jumpy_tut15.py</code> with Python 3.',
    tech: ['Python', 'OOP'],
    link: 'projects/jumpy.zip',
    linkLabel: 'Download Game',
  },
];

function createProjectCard(project) {
  return `
    <div class="col-md-4 mb-4">
      <div class="card h-100">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">${project.name}</h5>
          <p class="card-text">${project.description}</p>
          <div class="mb-2">
            ${project.tech.map(t => `<span class="badge bg-secondary me-1">${t}</span>`).join(' ')}
          </div>
          <a href="${project.link}" class="btn btn-primary mt-auto" target="_blank">${project.linkLabel || 'View Project'}</a>
        </div>
      </div>
    </div>
  `;
}

document.addEventListener('DOMContentLoaded', () => {
  const projectCards = document.getElementById('project-cards');
  if (projectCards) {
    projectCards.innerHTML = projects.map(createProjectCard).join('');
  }
});
