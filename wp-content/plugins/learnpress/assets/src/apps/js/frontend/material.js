import { addQueryArgs } from '@wordpress/url';
import apiFetch from '@wordpress/api-fetch';


export default function lpMaterialsLoad ( is_curriculum = false ) {
	// console.log('loaded');
	const Sekeleton = () => {
		const elementSkeleton = document.querySelector( '.lp-material-skeleton' );
			  
		if ( ! elementSkeleton ) {
			return;
		}
		const loadMoreBtn = elementSkeleton.querySelector( '.lp-loadmore-material' );
		elementSkeleton.querySelector( '.course-material-table' ).style.display = 'none';
		loadMoreBtn.style.display = 'none';
		getResponse( elementSkeleton );
	};
	const getResponse = async ( ele, page = 1 ) => {
		let itemID = 0;
		if ( is_curriculum ) {
			itemID = lpCourseItem ? lpCourseItem.id : 0;
		} else {
			itemID = lpGlobalSettings.post_id;
		}
		const elementMaterial = ele.querySelector( '.course-material-table' );
		const loadMoreBtn     = document.querySelector( '.lp-loadmore-material' )
		try {
			const response = await apiFetch( {
				path: addQueryArgs( `lp/v1/material/item-materials/${itemID}`, {
					page: page,
				} ),
				method: 'GET',
			} );
			const { data, status, message, load_more } = response;
			// console.log(response);
			// let section_ids = data.section_ids;
			if ( status !== 200 ) {
				throw new Error( message || 'Error' );
			}
			if ( data.length > 0 ) {
				if ( ele.querySelector( '.lp-skeleton-animation' ) ) {
					ele.querySelector( '.lp-skeleton-animation' ).remove();	
				}
				// console.log( data );
				elementMaterial.style.display = 'table';
				elementMaterial.querySelector( 'tbody' ).insertAdjacentHTML( 'beforeend', data );
				// for (var i = 0; i < data.length; i++) {
				// 	insertRow( elementMaterial.querySelector( 'tbody' ), data[i].file_name, data[i].file_type, data[i].file_size, data[i].file_path );
				// }
			}
			if ( load_more ) {
				loadMoreBtn.style.display = 'inline-block';
				loadMoreBtn.setAttribute( 'page', page + 1 );
				if ( loadMoreBtn.classList.contains( 'loading' ) ) {
					loadMoreBtn.classList.remove( 'loading' );
				}
			} else {
				loadMoreBtn.style.display = 'none';
			}
		} catch ( error ) {
			console.log( error.message );
		}
	};
	/*
	const insertRow = ( tbody, file_name, file_type, file_size, file_url ) => {
		if ( !tbody ) {
			return;
		}
		tbody.insertAdjacentHTML( 
			'beforeend',
			`<tr>
                <td colspan="4">${file_name}</td>
                <td>${file_type}</td>
                <td>${file_size}</td>
                <td>
                    <a href="${file_url}" target="_blank">
                        <i class="fas fa-file-download btn-download-material"></i>
                    </a>
                </td>
            </tr>`
			 );
	}
	*/
	Sekeleton();
	document.addEventListener( 'click', function( e ) {
		let target = e.target;
		if ( target.classList.contains( 'lp-loadmore-material' ) ) {
			const elementSkeleton = document.querySelector( '.lp-material-skeleton' ),
				  loadMoreBtn     = elementSkeleton.querySelector( '.lp-loadmore-material' );
			let page = ~~ target.getAttribute( 'page' );
			target.classList.add( 'loading' );
			getResponse( elementSkeleton, page );
			// target.classList.remove( 'loading' );
		}
	} );
}