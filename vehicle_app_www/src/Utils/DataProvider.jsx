import React, { createContext, useState, useEffect } from "react";

import { isAuth } from "./Auth";
import axios from "axios";
import PropTypes from "prop-types"
import Swal from 'sweetalert2'

export const DataContext = createContext(null);

export const DataProvider = ({ children }) => {
  DataProvider.propTypes = {
    children: PropTypes.string,
  };
    const [userDetail, setUserDetail] = useState([]);
    const [isLoggedIn, setIsLoggedIn] = useState(false);
    const apiUrl = import.meta.env.VITE_REACT_APP_API;

    const logout = () => {
      axios({
        method: "POST",
        url: apiUrl + `auth/logout`,
        headers: {
          Authorization: `Bearer ${isAuth()}`,
        },
      })
        .then((res) => {
          if (res.data.statusCode === 200 && res.data.status === 'success') {
            localStorage.removeItem("auth_token");
            localStorage.removeItem("user");
            setIsLoggedIn(false);
            setUserDetail([]);
            window.location.replace("login");
          }
        })
        .catch((err) => {
          if (err.response.status === 401) {
            localStorage.removeItem("auth_token");
            localStorage.removeItem("user");
            setIsLoggedIn(false);
            setUserDetail([]);
           
            Swal.fire({  
              icon: 'error',  
              text: "Unauthenticated. Please Login",
            }); 
            setTimeout(() => {
              window.location.replace("login");
            }, 2000);
          }else{
            console.error(err);
          }
        });
    };

    const getData = async () => {
      if (isAuth()) {
        await axios({
          method: "GET",
          url: apiUrl + `auth/me`,
          headers: {
            Authorization: `Bearer ${isAuth()}`,
            "Content-Type": "application/json",
          },
        })
          .then(async (res) => {
            if (res.data.statusCode === 200 && res.data.status === 'success') {
              const response = await res.data.data;
              setUserDetail(response);
              setIsLoggedIn(true);
            }
          })
          .catch((err) => {
            if (err.response.status === 401) {
              localStorage.removeItem("auth_token");
              localStorage.removeItem("user");
              setIsLoggedIn(false);
              setUserDetail([]);
             
              Swal.fire({  
                icon: 'error',  
                text: "Unauthenticated. Please Login",
              }); 
              setTimeout(() => {
                window.location.replace("login");
              }, 2000);
            }else{
              console.error(err);
            }
          });
      }
    };
  
    useEffect(() => {
      getData();
  }, []);
  
    return (
      <DataContext.Provider value={{ userDetail, isLoggedIn, logout }}>
        {children}
      </DataContext.Provider>
    );
  };
