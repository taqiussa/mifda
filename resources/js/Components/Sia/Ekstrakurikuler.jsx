import { forwardRef, useEffect, useRef } from 'react';

export default forwardRef(function Kelas(
    { name, id, value, message, className, required, isFocused, handleChange, listEkstrakurikuler },
    ref
) {

    const input = ref ? ref : useRef();

    useEffect(() => {

        if (isFocused) {

            input.current.focus();

        }

    }, []);

    return (
        <div className='flex flex-col text-slate-600 capitalize'>
            <div>
                ekstrakurikuler
            </div>
            <div>
                <select
                    name={name}
                    id={id}
                    value={value}
                    className={
                        `border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm w-full ` +
                        className
                    }
                    ref={input}
                    required={required}
                    onChange={(e) => handleChange(e)}
                >

                    <option value="">Pilih Ekstrakurikuler</option>

                    {listEkstrakurikuler.map((ekstra, index) => (
                        <option key={index} value={ekstra.id}>{ekstra.nama}</option>
                    ))}

                </select>
            </div>
            {message ?
                <div className='text-sm text-red-600'>
                    {message}
                </div>
                :
                null
            }
        </div>
    )
});
