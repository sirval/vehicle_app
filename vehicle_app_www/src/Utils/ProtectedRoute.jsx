import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import { isAuth } from "./Auth";
import PropTypes from "prop-types";

const ProtectedRoutes = (props) => {
  ProtectedRoutes.propTypes = {
    children: PropTypes.string,
  };
  const navigate = useNavigate();
  const [isLoggedIn, setIsLoggedIn] = useState(false);
  //check if user token exists
  const checkUserToken = () => {
    if (!isAuth()) {
      setIsLoggedIn(false);
      return navigate("/login");
    }
    setIsLoggedIn(true);
  };

  useEffect(() => {
    checkUserToken();
  }, [isLoggedIn]);

  return <React.Fragment>{isLoggedIn ? props.children : null}</React.Fragment>;
};

export default ProtectedRoutes;
