@include('partials.__header', [$title])
<header class="max-w-lg max- mx-auto">
        <a href="#">
            <h1 class="text-4xl font-bold text-white text-center">Edit {{$student->f_name}} {{$student->l_name}}</h1>
        </a>
    </header>
    <main class="bg-white max-w-lg mx-auto p-8 my-10 rounded-lg shadow-2xl">
        <section class="mt-10">
            <form action="/student/{{$student->id}}" method="POST" class="flex flex-col" enctype="multipart/form-data">
            @method('PUT')    
            @csrf
                <div class="flex justify-center items-center my-4">
                        @php
                           $default_profile = "https://api.dicebear.com/9.x/initials/svg?seed=".$student->f_name."-".$student->l_name.".svg"
                        @endphp
                            <img class="w-[200px] h-[200px] rounded-full" src="{{$student->student_image ? asset("storage/student/".$student->student_image): $default_profile}}">  
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <div class="label block text-gray-700 text-sm font-bold mb-2 ml-3">
                        <label for="f_name" class="block text-gray-700 text-sm font-bold mb-2 ml-3">First Name</label>
                        <input type="text" name="f_name" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3" autocomplete="off" value={{$student->f_name}}>
                            @error('f_name')
                                <p class="text-red-500 text-xs mt-2 p-1">
                                    {{$message}}
                                </p>
                            @enderror
                    </div>
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <div class="label block text-gray-700 text-sm font-bold mb-2 ml-3">
                        <label for="l_name" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Last Name</label>
                        <input type="text" name="l_name" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3" autocomplete="off" value={{$student->l_name}}>
                            @error('l_name')
                                <p class="text-red-500 text-xs mt-2 p-1">
                                    {{$message}}
                                </p>
                            @enderror
                    </div>
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <div class="label block text-gray-700 text-sm font-bold mb-2 ml-3">
                        <label for="gender" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Gender</label>
                        <select name="gender" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3">
                            <option value="" {{$student->gender == "" ? 'selected' : ''}}></option>
                            <option value="Male" {{$student->gender == "Male" ? 'selected' : ''}}>Male</option>
                            <option value="Female" {{$student->gender == "Female" ? 'selected' : ''}}>Female</option>
                        </select>
                            @error('gender')
                                <p class="text-red-500 text-xs mt-2 p-1">
                                    {{$message}}
                                </p>
                            @enderror
                    </div>
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <div class="label block text-gray-700 text-sm font-bold mb-2 ml-3">
                        <label for="age" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Age</label>
                        <input type="number" name="age" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3" autocomplete="off" value={{$student->age}}>
                            @error('age')
                                <p class="text-red-500 text-xs mt-2 p-1">
                                    {{$message}}
                                </p>
                            @enderror
                    </div>
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <div class="label block text-gray-700 text-sm font-bold mb-2 ml-3">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Email</label>
                        <input type="email" name="email" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3"autocomplete="off" value={{$student->email}}>
                            @error('email')
                                <p class="text-red-500 text-xs mt-2 p-1">
                                    {{$message}}
                                </p>
                            @enderror
                    </div>
                </div>

                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <div class="label block text-gray-700 text-sm font-bold mb-2 ml-3">
                        <label for="student-image" class="block text-gray-700 text-sm font-bold mb-2 ml-3">Student Image</label>
                        <input type="file" name="student_image" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-400 px-3"autocomplete="off" value={{$student->student_image}}>
                            @error('student_image')
                                <p class="text-red-500 text-xs mt-2 p-1">
                                    {{$message}}
                                </p>
                            @enderror
                    </div>
                </div>

                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200" type="submit">Update</button>
                
            </form>
            <form action="/student/{{$student->id}}" method="POST">
                @method('DELETE')
                @csrf
                <button type="submit" class="w-full mt-2 bg-red-600 hover:bg-red-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200" type="submit">Delete</button>
            </form>
        </section>
    </main>
@include('partials.__footer')