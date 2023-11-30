import { useContext } from "react";
import { DataContext } from "../Utils/DataProvider";
import { Link } from "react-router-dom";
const Navbar = (prop) => {
    const { isLoggedIn, logout } = useContext(DataContext);
    const loginState = () => {
        if (isLoggedIn) {
            return (
                <>
                    <span onClick={logout} type="submit" className="group flex items-center hover:cursor-pointer hover:text-gray z-0 relative">
                        Logout
                    </span>
                </>
            )
        }else {
            <>
                <Link to="/login" className="group flex items-center hover:cursor-pointer hover:text-gray z-0 relative">
                    Login
                </Link>
            </>
        }
    }
    return(
        <div className="flex justify-between text-white items-center">
            <h1 className={`${prop.dark ? "text-white" : "text-black"} font-bold text-2xl`}>Vehicle Lookup</h1>
           { loginState() }
        </div>
    )
}
export default Navbar;