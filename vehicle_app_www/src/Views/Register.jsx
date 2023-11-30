import React from "react"
import { Link, useNavigate } from "react-router-dom"
import axios from "axios";
import { useFormik } from "formik";
import * as Yup from 'yup';
import "yup-phone";
import Swal from 'sweetalert2'

const Register = () => {
    const navigate = useNavigate();

    const validationSchema = Yup.object({
        name: Yup.string()
            .required("Name is required"),
        phone: Yup.string()
            .required("Phone number is required"),
        password: Yup.string()
            .min(6, "Password must not be less than 6 characters")
            .required("Password is required"),
    });

    const formik = useFormik({
        initialValues: {
            name: '',
            phone: '',
            password: ''
        },
        validationSchema: validationSchema,
        onSubmit: (values) => {
            let formData = {
                phone: values.phone,
                password: values.password,
                name: values.name,
            };
            axios({
            method: "POST",
            url: import.meta.env.VITE_REACT_APP_API + `auth/register`,
            data: formData,
            })
            .then((res) => {
                console.log(res);
                if (res.data.statusCode === 201 && res.data.status === 'success') {
                    Swal.fire({  
                        icon: 'success',  
                        text: res.data.response,
                    }); 
                    localStorage.removeItem("auth_token");
                    localStorage.removeItem("user");
                    localStorage.setItem('user_id', JSON.stringify(res.data.data.user_id))

                setTimeout(() => {
                    navigate("/verify-phone");
                }, 2000);
                } else {
                    Swal.fire({  
                        icon: 'error',  
                        text: res.data.response,
                    }); 
                }
            })
            .catch((err) => {
                console.log(err);
                Swal.fire({  
                    icon: 'error',  
                    text: 'Oops! Something went wrong while trying to login. Please try again later',
                });
            });
        },
    });
   
    return (
        <div className="relative flex flex-col justify-center min-h-screen overflow-hidden">
            <div className="w-full p-6 m-auto bg-white rounded-md shadow-xl shadow-rose-600/40 ring ring-2 ring-purple-600 lg:max-w-xl">
                <h1 className="text-3xl font-semibold text-center text-purple-700 underline uppercase decoration-wavy">
                   Register
                </h1>
                <form onSubmit={formik.handleSubmit} className="mt-6">
                <div className="mb-2">
                        <label htmlFor="name"
                            className="block text-sm font-semibold text-gray-800"
                        >
                            Name
                        </label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            className="block w-full px-4 py-2 mt-2 text-purple-700 bg-white border rounded-md focus:border-purple-400 focus:ring-purple-300 focus:outline-none focus:ring focus:ring-opacity-40"
                            {...formik.getFieldProps('name')}
                        />
                        {formik.touched.name && formik.errors.name && (
                            <div className="text-red">{formik.errors.name}</div>
                        )}
                    </div>

                    <div className="mb-2">
                        <label htmlFor="phone"
                            className="block text-sm font-semibold text-gray-800"
                        >
                            Phone
                        </label>
                        <input
                            type="phone"
                            name="phone"
                            id="phone"
                            className="block w-full px-4 py-2 mt-2 text-purple-700 bg-white border rounded-md focus:border-purple-400 focus:ring-purple-300 focus:outline-none focus:ring focus:ring-opacity-40"
                            {...formik.getFieldProps('phone')}
                        />
                        {formik.touched.phone && formik.errors.phone && (
                            <div className="text-red">{formik.errors.phone}</div>
                        )}
                    </div>
                    <div className="mb-2">
                        <label
                            htmlFor="password"
                            className="block text-sm font-semibold text-gray-800"
                        >
                            Password
                        </label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            className="block w-full px-4 py-2 mt-2 text-purple-700 bg-white border rounded-md focus:border-purple-400 focus:ring-purple-300 focus:outline-none focus:ring focus:ring-opacity-40"
                            {...formik.getFieldProps('password')}
                        />
                        {formik.touched.password && formik.errors.password && (
                            <div className="text-red">{formik.errors.password}</div>
                        )}
                    </div>
                   
                    <div className="mt-6">
                        <button type="submit" className="w-full px-4 py-2 tracking-wide text-white transition-colors duration-200 transform bg-purple-700 rounded-md hover:bg-purple-600 focus:outline-none focus:bg-purple-600">
                            Register
                        </button>
                    </div>
                </form>

                <p className="mt-8 text-xs font-light text-center text-gray-700">
                    {" "}
                    Already registered?{" "}
                    <Link to="/login" className="font-medium text-purple-600 hover:underline">
                        Login
                    </Link>
                </p>
            </div>
        </div>
    )
}
  
export default Register