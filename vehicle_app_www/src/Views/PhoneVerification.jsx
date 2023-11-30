import React from "react"
import { Link, useNavigate } from "react-router-dom"
import axios from "axios";
import { useFormik } from "formik";
import * as Yup from 'yup';
import "yup-phone";
import Swal from 'sweetalert2'

const PhoneVerification = () => {
    const navigate = useNavigate();

    const validationSchema = Yup.object({
        verify_code: Yup.string()
            .required("Verification code is required"),
    });

    const formik = useFormik({
        initialValues: {
            verify_code: ''
        },
        validationSchema: validationSchema,
        onSubmit: (values) => {
            console.log(values);
           
            let formData = {
                verify_code: values.verify_code,
            };
            axios({
                method: "POST",
                url: import.meta.env.VITE_REACT_APP_API + `auth/verify-code`,
                data: formData,
            })
            .then((res) => {
                console.log(res);
                if (res.data.statusCode === 200 && res.data.status === 'success') {
                    Swal.fire({  
                        icon: 'success',  
                        text: res.data.response,
                    });
                setTimeout(() => {
                    navigate("/login");
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

    const handleResendCode = () => {
        const userId = localStorage.getItem('user_id')
        if (!userId || userId === "undefined") {
            Swal.fire({  
                icon: 'error',  
                text: 'Invalid user',
            });
            return;
        }
        axios({
            method: "POST",
            url: import.meta.env.VITE_REACT_APP_API + `auth/resend-code/${userId}`,
            })
            .then((res) => {
                console.log(res);
                if (res.data.statusCode === 200 && res.data.status === 'success') {
                    Swal.fire({  
                        icon: 'success',  
                        text: res.data.response,
                    });
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
    }
   
    return (
        <div className="relative flex flex-col justify-center min-h-screen overflow-hidden">
            <div className="w-full p-6 m-auto bg-white rounded-md shadow-xl shadow-rose-600/40 ring ring-2 ring-purple-600 lg:max-w-xl">
                <h1 className="text-3xl font-semibold text-center text-purple-700 underline uppercase decoration-wavy">
                   Phone Number Verification
                </h1>
                <form onSubmit={formik.handleSubmit} className="mt-6">
                <div className="mb-2">
                        <label htmlFor="verify_code"
                            className="block text-sm font-semibold text-gray-800"
                        >
                            Verification code
                        </label>
                        <input
                            type="text"
                            name="verify_code"
                            id="verify_code"
                            className="block w-full px-4 py-2 mt-2 text-purple-700 bg-white border rounded-md focus:border-purple-400 focus:ring-purple-300 focus:outline-none focus:ring focus:ring-opacity-40"
                            {...formik.getFieldProps('verify_code')}
                        />
                        {formik.touched.verify_code && formik.errors.verify_code && (
                            <div className="text-red">{formik.errors.verify_code}</div>
                        )}
                    </div>
                    
                    <span style={{ cursor: 'pointer' }}
                        onClick={handleResendCode}
                        className="text-xs text-purple-600 hover:underline"
                    >
                        Resend Code
                    </span>
                    <div className="mt-6">
                        <button type="submit" className="w-full px-4 py-2 tracking-wide text-white transition-colors duration-200 transform bg-purple-700 rounded-md hover:bg-purple-600 focus:outline-none focus:bg-purple-600">
                            Verify
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
  
export default PhoneVerification