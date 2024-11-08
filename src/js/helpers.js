async function auxiliarInstitucion(entidad,url){
    console.log(entidad)
    await sessionStorage.setItem('institucion',JSON.stringify(entidad))
    window.location.href = url;
}

async function getInstitucion() {
    const institucion = sessionStorage.getItem('institucion')
    return institucion
}