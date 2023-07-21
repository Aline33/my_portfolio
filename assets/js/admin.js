const project = document.getElementById('pf-project-js');
const skill = document.getElementById('pf-skill-js');
const btnProject = document.getElementById('pf-btn-project-js');
const btnSkill = document.getElementById('pf-btn-skill-js');
btnSkill.addEventListener('click', event => {
    project.classList.add('hidden');
    skill.classList.remove('hidden');
});
btnProject.addEventListener('click', event => {
    project.classList.remove('hidden');
    skill.classList.add('hidden');
});