
const Navbar = (prop) => {
    console.log(prop);
    return(
        <div className="flex justify-between text-white items-center">
            <h1 className={`${prop.dark ? "text-white" : "text-black"} font-bold text-2xl`}>Vehicle Lookup</h1>
            <span onClick={prop.onClick} type="submit" className="group flex items-center hover:cursor-pointer hover:text-gray z-0 relative">
                        Logout
                    </span>
        </div>
    )
}
export default Navbar;