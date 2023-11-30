import React from "react"
import { Link } from "react-router-dom"

const Index = () => {
    return (
        <div className="leading-normal tracking-normal text-indigo-400 bg-cover bg-fixed" style={{ backgroundImage: `url(images/header.png)`,
        backgroundSize: 'cover',
        backgroundPosition: 'center',
        minHeight: '100vh', }}>
            <div className="h-full">
                {/* <!--Nav--> */}
                <div className="w-full container mx-auto">
                <div className="w-full flex items-center justify-between">
                    <a className="flex items-center text-indigo-400 no-underline hover:no-underline font-bold text-2xl lg:text-4xl" href="#">
                    Vehicle{" "}<span className="bg-clip-text text-transparent bg-gradient-to-r from-green-400 via-pink-500 to-purple-500">{" "}Lookup</span>
                    </a>
        
                    <div className="flex w-1/2 justify-end content-center">
                    
                    </div>
                </div>
                </div>
        
                {/* <!--Main--> */}
                <div className="container pt-24 md:pt-36 mx-auto flex flex-wrap flex-col md:flex-row items-center">
                {/* <!--Left Col--> */}
                <div className="flex flex-col w-full xl:w-2/5 justify-center lg:items-start overflow-y-hidden">
                    <h1 className="my-4 text-3xl md:text-5xl text-white opacity-75 font-bold leading-tight text-center md:text-left">
                   
                    <span className="bg-clip-text text-transparent bg-gradient-to-r from-green-400 via-pink-500 to-purple-500">
                        Let's help you lookup for your car detail
                    </span>
                    
                    </h1>
                    <p className="leading-normal text-base md:text-2xl mb-8 text-center md:text-left">
                    It's that easy, right!
                    </p>
        
                    
        
                    <div className="flex items-center justify-between pt-4">
                        <Link to="/dashboard"
                            className="bg-gradient-to-r from-purple-800 to-green-500 hover:from-pink-500 hover:to-green-500 text-white font-bold py-2 px-4 rounded focus:ring transform transition hover:scale-105 duration-300 ease-in-out">
                            Get Started
                        </Link>
                    </div>
                </div>
        
                {/* <!--Right Col--> */}
                <div className="w-full xl:w-3/5 p-12 overflow-hidden"> <img className="mx-auto w-full md:w-4/5 transform -rotate-6 transition hover:scale-105 duration-700 ease-in-out hover:rotate-6" src="images/icon-car.svg"
                    alt="Car Icon" />
                   
                </div>
        
               
               
                </div>
            </div>
        </div>
    )
}
  
export default Index