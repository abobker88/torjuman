const primaryNav = document.querySelector('.primary-navigation')
const menuToggle = document.querySelector('.mobile-menu-toggle')


menuToggle.addEventListener("click", ()=>{
    const visibility = primaryNav.getAttribute("data-visible")
    if(visibility==="false"){
        primaryNav.setAttribute("data-visible", true)
        menuToggle.setAttribute("aria-expanded", true)
    }else if(visibility==="true"){
        primaryNav.setAttribute("data-visible", false)
        menuToggle.setAttribute("aria-expanded", false)


    }
})