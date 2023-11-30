import { useContext, useState } from "react"

import { Link, useNavigate } from "react-router-dom"
import Navbar from "../components/Navbar"
import VehicleDetail from "../components/VehicleDetail"
import Searchbar from "../components/Searchbar"
import Loader from "../components/Loader"

import axios from "axios";
import { useFormik } from "formik";
import * as Yup from 'yup';
import "yup-phone";
import Swal from 'sweetalert2'
import { isAuth } from "../Utils/Auth"
import { DataContext } from "../Utils/DataProvider"

function Dashboard() {
  const { setIsLoggedIn, logout } = useContext(DataContext);
  const [vinData, setVinData] = useState({
    vin: "",
    specification: {}
  })

  const navigate = useNavigate()


  // const [loading,setLoading] = useState(true)
  const [theme,setTheme] = useState(true)

    const validationSchema = Yup.object({
        vin: Yup.string()
            .required("Required")
            .min(17, "Not less than 17 characters"),
    });

    const formik = useFormik({
        initialValues: {
          vin: '',
        },
        validationSchema: validationSchema,
        onSubmit: (values) => {
            let formData = {
            vin: values.vin,
            };
            axios({
            method: "POST",
            url: import.meta.env.VITE_REACT_APP_API + `vehicle/vin`,
            headers: {
              Authorization: `Bearer ${isAuth()}`,
              "Content-Type": "application/json",
            },
            data: formData,
            })
            .then((res) => {
                if (res.data.statusCode === 200 && res.data.status === 'success') {
                  setVinData(res.data.data);
                } else {
                    Swal.fire({  
                        icon: 'error',  
                        text: res.data.response,
                    });
                }
            })
            .catch((err) => {
                console.error(err);
                Swal.fire({  
                    icon: 'error',  
                    text: 'Oops! Something went wrong while trying to login. Please try again later',
                });
            });
        },
    });

    const handleLogout = () => {
      logout()
      setIsLoggedIn(false);
    }
 
  return (
    <div className={`${theme ? "bg-dark-navy-blue" : "bg-whitish-blue"} w-full min-h-screen flex flex-col justify-center items-center py-20`}>
      {/* {loading ? <Loader
      dark = {theme}/> : <> */}
        <div className="w-11/12 xs:w-5/6 sm:w-110 600:w-100 lg:w-120 ">
          <Navbar 
            onClick = {handleLogout}
            dark = {theme}
          />
       </div>
       <div className="xs:w-5/6 w-11/12 sm:w-110 600:w-100 lg:w-120 ">
          <form onSubmit = {formik.handleSubmit} className={`${theme ? "bg-navy-blue" : "bg-white"} flex justify-between rounded-xl mt-8 text-xs 480:text-base shadow-2xl`}>
            <div className="flex w-full py-3 ml-5 mr-2 500:mr-3">
              <input 
                  className={`${theme ? "bg-navy-blue" : "bg-white"} ${theme ? "text-white" : "text-black"} ${theme ? "placeholder-white" : "placeholder-grayish-blue"} w-full outline-none  text-ellipsis`} 
                  type="text" 
                  name="vin" 
                  id="vin" 
                  placeholder="Search for vehicle..."  
                  autoComplete="off" 
                  spellCheck = "false"
                  {...formik.getFieldProps('vin')}
              />
            </div>
            
            
            {formik.touched.vin && formik.errors.vin && (
                <span className="text-red font-bold w-44 m-auto">{formik.errors.vin}</span>
            )}
            <button type="submit" className="bg-blue hover:bg-blue-2 active:bg-blue-2 text-white rounded-xl p-3 my-2 mr-2 font-bold">Search</button>
          </form>
       </div>
       <div className ="xs:w-5/6 w-11/12 600:w-100 sm:w-110 lg:w-120 ">
        <VehicleDetail 
        vehicle = {vinData}
        dark = {theme}
        />
       </div>
       {/* </>} */}
    </div>
    
  )
}

export default Dashboard;